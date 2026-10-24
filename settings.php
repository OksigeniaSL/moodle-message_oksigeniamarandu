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
 * Administration: where the channel is set up, and whether it is ready.
 *
 * @package    message_oksigeniamarandu
 * @copyright  2026 Oksigenia SL <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    require_once($CFG->dirroot . '/message/output/oksigeniamarandu/message_output_oksigeniamarandu.php');
    $ready = (new message_output_oksigeniamarandu())->is_system_configured();
    $settings->add(new admin_setting_heading(
        'message_oksigeniamarandu/setup',
        get_string('setup', 'message_oksigeniamarandu'),
        get_string('setup_desc', 'message_oksigeniamarandu', (new moodle_url('/local/oksigeniamarandu/wizard.php'))->out())
            . html_writer::tag('p', get_string($ready ? 'status:ready' : 'status:notready', 'message_oksigeniamarandu'), [
                'class' => $ready ? 'text-success' : 'text-warning',
            ])
    ));
}
