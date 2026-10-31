# Mobile messaging for the notifications of Moodle: WhatsApp and Telegram (Oksigenia Marandu)

[![License: GPLv3](https://img.shields.io/badge/license-GPLv3+-blue.svg)](LICENSE)
![Moodle](https://img.shields.io/badge/Moodle-4.5%E2%80%935.3-orange)
![Status](https://img.shields.io/badge/status-pre--alpha-red)
[![Sponsor](https://img.shields.io/badge/sponsor-Oksigenia-00d4ff)](https://oksigenia.com/en/open-source#sponsor)

The notification channel of **Oksigenia Marandu**: one column, "Mobile messaging", in the notification preferences,
next to the web and email. Each user joins on WhatsApp, on Telegram or on both, and chooses which notifications of
Moodle™ reach their phone. They go out from the site's own official WhatsApp Business account and its own Telegram bot,
only to those who joined, within the limits and the quiet hours of the site. A channel to come is one more option of
the same column. *Marandu* means "news" or "notice" in Guarani.

[Leer en español](README.es.md)

## How it works

- The site connects WhatsApp, Telegram or both with
  [Oksigenia Marandu](https://github.com/OksigeniaSL/moodle-local_oksigeniamarandu) (`local_oksigeniamarandu`,
  required) and switches on its general notice for each channel. Until then, the column stays hidden.
- Each user joins in *Preferences > Notification preferences*, in the settings of the column: on WhatsApp, a private
  page opens WhatsApp on the phone with the message already written, or shows a QR code on a computer; on Telegram, the
  bot of the site opens with the user's code. Nothing is sent to anyone who has not written first, and the opt-out
  word (or blocking the bot) stops everything.
- On the same page, each user switches on the notifications they want on their phone. The administrator can turn
  kinds of notification off or lock them in *Site administration > Messaging > Notification settings*.
- What reaches the phone is the name of the site, the subject of the notification and a button to read it on the
  site. The text of the notification stays on the site.

## Status

**Pre-alpha.** Each version is small and tested before it is released. Not for production sites.

## Install

1. Install [local_oksigeniamarandu](https://github.com/OksigeniaSL/moodle-local_oksigeniamarandu) 0.13.0 or later.
2. Copy this plugin to `message/output/oksigeniamarandu` in your Moodle (4.5 to 5.3).
3. Visit *Site administration > Notifications* to finish the install.

## Development

Code, comments and commit messages in English; texts in the language packs (`lang/en`, `lang/es`). The tests run with
`moodle-plugin-ci` in GitHub Actions on Moodle 4.5 and 5.3 (PostgreSQL) and on 5.3 with MariaDB 11.4. See
[CONTRIBUTING.md](CONTRIBUTING.md).

## License

GNU GPL v3 or later. See [LICENSE](LICENSE).

© 2026 Oksigenia SL — dev@oksigenia.cc

The word Moodle and associated Moodle logos are trademarks or registered trademarks of Moodle Pty Ltd or its
related affiliates. Oksigenia is not affiliated with Moodle HQ and is not a Moodle Certified Partner. WhatsApp is a
trademark of Meta Platforms, Inc. This plugin is not made, endorsed or sponsored by Meta or by Telegram.
