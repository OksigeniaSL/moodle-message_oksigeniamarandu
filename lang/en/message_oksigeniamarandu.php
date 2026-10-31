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
 * English strings for message_oksigeniamarandu.
 *
 * @package    message_oksigeniamarandu
 * @copyright  2026 Oksigenia SL <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['intro'] = 'The notifications you switch on in the column "Mobile messaging" reach your phone, by the channel you join.';
$string['join_telegram'] = 'Join on Telegram';
$string['join_whatsapp'] = 'Join on WhatsApp';
$string['joined_telegram'] = 'joined, in the chat of the bot of the site. To stop them, write {$a->stop} or block the bot.';
$string['joined_whatsapp'] = 'joined, at {$a->where}. To stop them, send "{$a->word}" to the number of the site.';
$string['nosubject'] = 'New notification';
$string['notjoined'] = 'not joined';
$string['notready'] = 'Mobile messaging is not ready on this site yet.';
$string['pluginname'] = 'Mobile messaging';
$string['privacy:metadata'] = 'Mobile messaging keeps nothing: it hands the notifications to Oksigenia Marandu, which keeps the numbers and chats, their consent and the queue, and answers for them.';
$string['setup'] = 'Set up';
$string['setup_desc'] = 'WhatsApp and Telegram are set up in <a href="{$a}">the panel of Oksigenia Marandu</a>. Notifications go out as its general notice, which has to be switched on there for each channel, in "Which notices go out". Then each user joins, in their notification preferences, on WhatsApp, on Telegram or on both, and chooses which notifications they get.';
$string['status:notready'] = 'Not ready yet: connect WhatsApp or Telegram in the panel and switch on the general notice for it in "Which notices go out".';
$string['status:ready'] = 'Ready: users can join from their notification preferences.';
