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
 * Steps of message_oksigeniamarandu for Behat.
 *
 * @package    message_oksigeniamarandu
 * @category   test
 * @copyright  2026 Oksigenia SL <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// NOTE: no MOODLE_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../../lib/behat/behat_base.php');

/**
 * Steps of message_oksigeniamarandu for Behat.
 */
class behat_message_oksigeniamarandu extends behat_base {
    /**
     * Opens the settings of the WhatsApp column in the notification preferences, as its cog does.
     *
     * The link starts with an empty box (a tooltip block inside an inline link), which WebDriver refuses to click.
     *
     * @When /^I open the settings of the WhatsApp channel$/
     */
    public function i_open_the_settings_of_the_whatsapp_channel(): void {
        $this->getSession()->executeScript(
            "document.querySelector(\"[data-processor-setting][data-name='oksigeniamarandu']\").click();"
        );
        $this->wait_for_pending_js();
        $this->ensure_element_is_visible('.modal.show', 'css_element');
    }
}
