<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace message_oksigeniamarandu;

use local_oksigeniamarandu\api;
use local_oksigeniamarandu\local\consent;
use local_oksigeniamarandu\local\queue;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/message/output/oksigeniamarandu/message_output_oksigeniamarandu.php');

/**
 * Tests for the WhatsApp channel. Made-up numbers.
 *
 * @package    message_oksigeniamarandu
 * @category   test
 * @copyright  2026 Oksigenia SL <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \message_output_oksigeniamarandu
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\message_output_oksigeniamarandu::class)]
final class message_output_oksigeniamarandu_test extends \advanced_testcase {
    /** @var \message_output_oksigeniamarandu The channel. */
    private $output;

    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
        $this->output = new \message_output_oksigeniamarandu();
    }

    /**
     * The account of the site connected and its general notice switched on.
     */
    private function ready(): void {
        set_config('phonenumberid', '1234567890', 'local_oksigeniamarandu');
        set_config('accesstoken', 'made-up', 'local_oksigeniamarandu');
        set_config('displayphone', '+34 900 000 000', 'local_oksigeniamarandu');
        set_config('enablednotices', 'local_oksigeniamarandu/notification', 'local_oksigeniamarandu');
    }

    /**
     * The bot of Telegram connected, with the general notice switched on for it.
     */
    private function telegram(): void {
        set_config('telegramtoken', \core\encryption::encrypt('123456789:' . str_repeat('A', 35)), 'local_oksigeniamarandu');
        set_config('telegrambot', 'marandu_example_bot', 'local_oksigeniamarandu');
        set_config('telegramnotices', 'local_oksigeniamarandu/notification', 'local_oksigeniamarandu');
    }

    /**
     * A user joins a number, as from the page the channel takes them to.
     *
     * @param \stdClass $user The user.
     * @param string $phone Digits with the country code.
     */
    private function join(\stdClass $user, string $phone): void {
        $code = api::invite(\message_output_oksigeniamarandu::COMPONENT, 0, (int)$user->id);
        consent::optin_from_message($phone, $code, 'wamid.TEST');
    }

    /**
     * Ready with a channel connected and the general notice on for it: WhatsApp, Telegram, or both.
     */
    public function test_is_system_configured(): void {
        $this->assertFalse($this->output->is_system_configured());
        $this->ready();
        $this->assertTrue($this->output->is_system_configured());
        set_config('enablednotices', '', 'local_oksigeniamarandu');
        $this->assertFalse($this->output->is_system_configured());
        $this->telegram();
        $this->assertSame(['telegram'], \message_output_oksigeniamarandu::channels());
        $this->assertTrue($this->output->is_system_configured());
    }

    /**
     * A user counts once their number has joined, and stops counting when it opts out or the user is suspended.
     */
    public function test_is_user_configured(): void {
        global $DB;
        $this->ready();
        $user = $this->getDataGenerator()->create_user();
        $other = $this->getDataGenerator()->create_user();
        $this->assertSame(0, $this->output->is_user_configured($user));

        $this->join($user, '34600000001');
        $this->assertSame(1, $this->output->is_user_configured($user));
        $this->assertSame(0, $this->output->is_user_configured($other));

        $user->suspended = 1;
        $this->assertSame(0, $this->output->is_user_configured($user));
        $user->suspended = 0;

        consent::optout('34600000001', 'whatsapp', 'wamid.TEST2');
        $this->assertSame(0, $this->output->is_user_configured($user));
        $this->assertSame(0, $DB->count_records(queue::TABLE));

        // Joined with a code from elsewhere (the app, a letter), it counts; on Telegram too, once the site has it.
        consent::optin_from_message('34600000002', api::invite('core', 0, (int)$other->id), 'wamid.TEST3');
        $this->assertSame(1, $this->output->is_user_configured($other));
        $third = $this->getDataGenerator()->create_user();
        consent::optin_from_message('tg:555', api::invite('core', 0, (int)$third->id), 'telegram:1');
        $this->assertSame(0, $this->output->is_user_configured($third));
        $this->telegram();
        $this->assertSame(1, $this->output->is_user_configured($third));
    }

    /**
     * The app reads the preferences through the web service of Moodle, which takes this as a number: without it, whoever has
     * not joined gets «Invalid response value detected» on the whole page.
     */
    public function test_preferences_for_the_app(): void {
        global $CFG;
        require_once($CFG->dirroot . '/message/externallib.php');
        $this->ready();
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        $configured = function () use ($user) {
            $clean = \core_external\external_api::clean_returnvalue(
                \core_message_external::get_user_notification_preferences_returns(),
                \core_message_external::get_user_notification_preferences((int)$user->id)
            );
            return array_column($clean['preferences']['processors'], 'userconfigured', 'name')['oksigeniamarandu'];
        };
        $this->assertSame(0, $configured());
        $this->join($user, '34600000001');
        $this->assertSame(1, $configured());
    }

    /**
     * A notification goes to the queue as the general notice, with the subject and a button to its page on the site.
     */
    public function test_send_message(): void {
        global $DB;
        $this->ready();
        $user = $this->getDataGenerator()->create_user();
        $this->join($user, '34600000001');
        $page = new \moodle_url('/mod/assign/view.php', ['id' => 3, 'action' => 'grading']);

        $this->assertTrue($this->output->send_message((object)[
            'userto' => $user,
            'subject' => "Assignment\ngraded",
            'contexturl' => $page->out(true),
            'notification' => 1,
            'savedmessageid' => 7,
        ]));
        $rows = $DB->get_records(queue::TABLE, null, 'id');
        $this->assertCount(1, $rows);
        $row = reset($rows);
        $this->assertSame('local_oksigeniamarandu', $row->component);
        $this->assertSame('notification', $row->notice);
        $this->assertSame([get_site()->fullname, 'Assignment graded'], json_decode($row->params, true));
        $this->assertSame($page->out(false), $row->url);

        // A link outside the site, or none, takes to the notification or the conversation on the site.
        $this->output->send_message((object)[
            'userto' => $user->id,
            'subject' => '',
            'contexturl' => 'https://example.com/elsewhere',
            'notification' => 1,
            'savedmessageid' => 7,
        ]);
        $this->output->send_message((object)['userto' => $user, 'subject' => 'Hi', 'notification' => 0, 'convid' => 5]);
        $rows = array_values($DB->get_records(queue::TABLE, null, 'id'));
        $this->assertSame(get_string('nosubject', 'message_oksigeniamarandu'), json_decode($rows[1]->params, true)[1]);
        $this->assertSame(
            (new \moodle_url('/message/output/popup/notifications.php', ['notificationid' => 7]))->out(false),
            $rows[1]->url
        );
        $this->assertSame((new \moodle_url('/message/index.php', ['convid' => 5]))->out(false), $rows[2]->url);
    }

    /**
     * Nothing to send is not an error, so that the other channels still get the message.
     */
    public function test_send_message_nothing_to_send(): void {
        global $DB;
        $user = $this->getDataGenerator()->create_user();
        $this->join($user, '34600000001');
        $message = (object)['userto' => $user, 'subject' => 'Hi', 'notification' => 1];
        $this->assertTrue($this->output->send_message($message));

        $this->ready();
        $other = $this->getDataGenerator()->create_user();
        $this->assertTrue($this->output->send_message((object)['userto' => $other, 'subject' => 'Hi', 'notification' => 1]));
        $this->assertSame(0, $DB->count_records(queue::TABLE));
    }

    /**
     * The form says how to join, and once joined, how to stop.
     */
    public function test_config_form(): void {
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        $preferences = new \stdClass();
        $this->output->load_data($preferences, $user->id);
        $this->assertStringContainsString(
            get_string('notready', 'message_oksigeniamarandu'),
            $this->output->config_form($preferences)
        );

        $this->ready();
        $this->telegram();
        $form = $this->output->config_form($preferences);
        $this->assertStringContainsString('join.php?channel=whatsapp', $form);
        $this->assertStringContainsString('join.php?channel=telegram', $form);

        // Joined on WhatsApp: it says where and how to stop; Telegram is still to join.
        $this->join($user, '34600000001');
        $form = $this->output->config_form($preferences);
        $this->assertStringContainsString('+34 6•• •• •• 01', $form);
        $this->assertStringNotContainsString('channel=whatsapp', $form);
        $this->assertStringContainsString('join.php?channel=telegram', $form);
    }
}
