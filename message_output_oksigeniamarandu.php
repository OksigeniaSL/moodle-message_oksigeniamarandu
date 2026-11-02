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

/**
 * The channel of the notifications of Moodle to the phone: WhatsApp, Telegram, and any channel Marandu has.
 *
 * @package    message_oksigeniamarandu
 * @copyright  2026 Oksigenia SL <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/message/output/lib.php');

use local_oksigeniamarandu\api;
use local_oksigeniamarandu\local\keywords;
use local_oksigeniamarandu\local\notices;

/**
 * One column, «Mobile messaging», for every channel: the notifications a user switches on in it go to whatever the
 * user joined (their WhatsApp, their Telegram, or both), as the general notice of Oksigenia Marandu: the name of the
 * site, the subject and a button to read them on the site. The text of the notification itself never leaves the site.
 * A channel to come is one more option in the settings of the column.
 *
 * @package    message_oksigeniamarandu
 * @copyright  2026 Oksigenia SL <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class message_output_oksigeniamarandu extends message_output {
    /** The notice of local_oksigeniamarandu that carries the notifications. */
    public const NOTICE = 'notification';

    /** The component of the links between users and their numbers. */
    public const COMPONENT = 'message_oksigeniamarandu';

    /**
     * Queues the notification for the numbers of the user; the queue of the main plugin sends it within the limits of
     * the site.
     *
     * Nothing to send is not an error: a false here would stop the message for every other channel too.
     *
     * @param \stdClass $eventdata The message, with userto and savedmessageid.
     * @return bool
     */
    public function send_message($eventdata) {
        $userto = is_object($eventdata->userto) ? $eventdata->userto : \core_user::get_user($eventdata->userto);
        if (!$userto || !$this->is_system_configured() || !$this->is_user_configured($userto)) {
            return true;
        }
        $site = format_string(get_site()->fullname, true, ['context' => \context_system::instance(), 'escape' => false]);
        $subject = trim((string)($eventdata->subject ?? ''));
        if ($subject === '') {
            $subject = get_string('nosubject', self::COMPONENT);
        }
        api::notify('local_oksigeniamarandu', self::NOTICE, [$site, $subject], self::link($eventdata), 0, (int)$userto->id);
        return true;
    }

    /**
     * Keeps whose preferences these are, for the form of the channel.
     *
     * @param \stdClass $preferences The preferences of the user.
     * @param int $userid The user.
     */
    public function load_data(&$preferences, $userid) {
        $preferences->oksigeniamarandu_userid = (int)$userid;
    }

    /**
     * What the user sees in the settings of the channel: whether the number has joined and, if not, how to join it.
     *
     * @param \stdClass $preferences The preferences of the user.
     * @return string HTML.
     */
    public function config_form($preferences) {
        global $USER;
        if (!$this->is_system_configured()) {
            return \html_writer::tag('p', get_string('notready', self::COMPONENT));
        }
        $userid = (int)($preferences->oksigeniamarandu_userid ?? $USER->id);
        $html = \html_writer::tag('p', get_string('intro', self::COMPONENT));
        $items = '';
        foreach (api::user_channels($userid) as $channel => $info) {
            if (!in_array($channel, self::channels(), true)) {
                continue;
            }
            if ($info['joined']) {
                $how = get_string('joined_' . $channel, self::COMPONENT, (object)[
                    'where' => $info['where'],
                    'word' => keywords::first('optoutkeywords'),
                    'stop' => '/' . get_string('telegram:cmd:stop', 'local_oksigeniamarandu'),
                ]);
                $items .= \html_writer::tag('li', \html_writer::tag('b', $info['name']) . ': ' . $how);
            } else if ($userid === (int)$USER->id) {
                // The way to join: a private page for WhatsApp, the bot itself for Telegram.
                $items .= \html_writer::tag('li', \html_writer::link(
                    new \moodle_url('/message/output/oksigeniamarandu/join.php', ['channel' => $channel]),
                    get_string('join_' . $channel, self::COMPONENT),
                    ['class' => 'btn btn-primary', 'target' => '_blank', 'rel' => 'noopener']
                ));
            } else {
                $items .= \html_writer::tag('li', \html_writer::tag('b', $info['name']) . ': '
                    . get_string('notjoined', self::COMPONENT));
            }
        }
        return $html . \html_writer::tag('ul', $items, ['class' => 'list-unstyled d-grid gap-2']);
    }

    /**
     * The form has nothing to keep: the number joins on WhatsApp.
     *
     * @param \stdClass $form The values of the form.
     * @param array $preferences The preferences to save.
     * @return bool
     */
    public function process_form($form, &$preferences) {
        return true;
    }

    /**
     * Ready when the account of the site is connected and its general notice is switched on.
     *
     * @return bool
     */
    public function is_system_configured() {
        return (bool)self::channels();
    }

    /**
     * The channels of the site that are ready and send the general notice, which is what this column sends.
     *
     * @return string[] whatsapp, telegram.
     */
    public static function channels(): array {
        $channels = [];
        foreach (api::channels() as $channel => $info) {
            if ($info['ready'] && in_array('local_oksigeniamarandu/' . self::NOTICE, notices::enabled($channel), true)) {
                $channels[] = $channel;
            }
        }
        return $channels;
    }

    /**
     * Whether the user has joined a number that has not opted out. As a number and not as true or false: the web service
     * of the preferences, which the app reads, declares it as an integer and refuses false.
     *
     * @param \stdClass|null $user The user; the current one if null.
     * @return int 1 or 0.
     */
    public function is_user_configured($user = null) {
        global $USER;
        $user = $user ?? $USER;
        if (empty($user->id) || !empty($user->deleted) || !empty($user->suspended) || ($user->auth ?? '') === 'nologin') {
            return 0;
        }
        // Joined with any code (these preferences, the app or a letter), on any channel of the site that sends.
        foreach (self::channels() as $channel) {
            if (api::user_joined((int)$user->id, $channel)) {
                return 1;
            }
        }
        return 0;
    }

    /**
     * Off for every user until they switch it on, and every kind of notification allowed.
     *
     * @return int
     */
    public function get_default_messaging_settings() {
        return MESSAGE_PERMITTED;
    }

    /**
     * Where the button of the notice goes: the page of the notification on this site.
     *
     * @param \stdClass $eventdata The message.
     * @return \moodle_url
     */
    private static function link($eventdata): \moodle_url {
        global $CFG;
        $url = $eventdata->contexturl ?? '';
        $url = $url instanceof \moodle_url ? $url->out(false) : str_replace('&amp;', '&', (string)$url);
        if (strpos($url, $CFG->wwwroot . '/') === 0) {
            return new \moodle_url($url);
        }
        if (!empty($eventdata->notification)) {
            $params = empty($eventdata->savedmessageid) ? [] : ['notificationid' => (int)$eventdata->savedmessageid];
            return new \moodle_url('/message/output/popup/notifications.php', $params);
        }
        return new \moodle_url('/message/index.php', empty($eventdata->convid) ? [] : ['convid' => (int)$eventdata->convid]);
    }
}
