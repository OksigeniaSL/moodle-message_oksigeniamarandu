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
 * Spanish strings for message_oksigeniamarandu.
 *
 * @package    message_oksigeniamarandu
 * @copyright  2026 Oksigenia SL <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['intro'] = 'Las notificaciones que enciendas en la columna «Mensajería móvil» te llegan al móvil, por el canal en el que te apuntes.';
$string['join_telegram'] = 'Apuntarme por Telegram';
$string['join_whatsapp'] = 'Apuntarme por WhatsApp';
$string['joined_telegram'] = 'apuntado, en el chat del bot del sitio. Para dejar de recibirlas, escribe {$a->stop} o bloquea el bot.';
$string['joined_whatsapp'] = 'apuntado, en el {$a->where}. Para dejar de recibirlas, manda «{$a->word}» al número del sitio.';
$string['nosubject'] = 'Notificación nueva';
$string['notjoined'] = 'sin apuntar';
$string['notready'] = 'La mensajería móvil todavía no está lista en este sitio.';
$string['pluginname'] = 'Mensajería móvil';
$string['privacy:metadata'] = 'La mensajería móvil no guarda nada: pasa las notificaciones a Oksigenia Marandu, que guarda los números y los chats, su consentimiento y la cola, y responde por ellos.';
$string['setup'] = 'Configuración';
$string['setup_desc'] = 'WhatsApp y Telegram se configuran en <a href="{$a}">el panel de Oksigenia Marandu</a>. Las notificaciones salen como su aviso general, que hay que encender allí para cada canal, en «Qué avisos salen». Después, cada usuario se apunta en sus preferencias de notificación, por WhatsApp, por Telegram o por los dos, y elige qué notificaciones le llegan.';
$string['status:notready'] = 'Todavía no está lista: conecta WhatsApp o Telegram en el panel y enciende para él el aviso general en «Qué avisos salen».';
$string['status:ready'] = 'Lista: los usuarios ya pueden apuntarse desde sus preferencias de notificación.';
