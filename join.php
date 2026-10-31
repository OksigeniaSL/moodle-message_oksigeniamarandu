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
 * Takes the user to where they join a channel with a code of their own, made when they ask for it: the private page of
 * WhatsApp, or the bot of Telegram, which opens with the code.
 *
 * @package    message_oksigeniamarandu
 * @copyright  2026 Oksigenia SL <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/message/output/oksigeniamarandu/message_output_oksigeniamarandu.php');

$PAGE->set_url(new moodle_url('/message/output/oksigeniamarandu/join.php'));
$PAGE->set_context(context_system::instance());
require_login(null, false);
if (isguestuser()) {
    throw new moodle_exception('noguest');
}

$processor = new message_output_oksigeniamarandu();
if (!\core_message\api::is_processor_enabled('oksigeniamarandu') || !$processor->is_system_configured()) {
    $PAGE->set_title(get_string('pluginname', 'message_oksigeniamarandu'));
    echo $OUTPUT->header();
    echo $OUTPUT->notification(get_string('notready', 'message_oksigeniamarandu'), 'info');
    echo $OUTPUT->continue_button(new moodle_url('/message/notificationpreferences.php'));
    echo $OUTPUT->footer();
    exit;
}

$channel = optional_param('channel', 'whatsapp', PARAM_ALPHA);
$channel = in_array($channel, message_output_oksigeniamarandu::channels(), true) ? $channel : 'whatsapp';
$code = \local_oksigeniamarandu\api::invite(message_output_oksigeniamarandu::COMPONENT, 0, (int)$USER->id);
redirect($channel === 'telegram' ? new moodle_url(\local_oksigeniamarandu\api::join_url('telegram', $code))
    : \local_oksigeniamarandu\api::signup_url($code));
