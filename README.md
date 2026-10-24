# WhatsApp notification channel for Moodle (Oksigenia Marandu)

[![License: GPLv3](https://img.shields.io/badge/license-GPLv3+-blue.svg)](LICENSE)
![Moodle](https://img.shields.io/badge/Moodle-4.5%E2%80%935.3-orange)
![Status](https://img.shields.io/badge/status-pre--alpha-red)
[![Sponsor](https://img.shields.io/badge/sponsor-Oksigenia-00d4ff)](https://oksigenia.com/en/open-source#sponsor)

The WhatsApp channel of **Oksigenia Marandu for WhatsApp**: each user chooses which notifications of Moodle™ reach
them on WhatsApp, next to the web and email, in their notification preferences. They go out from the site's own
official WhatsApp Business account, only to numbers that opted in, within the spending cap and the quiet hours of the
site. *Marandu* means "news" or "notice" in Guarani.

[Leer en español](README.es.md)

## How it works

- The site sets up its WhatsApp account with
  [Oksigenia Marandu for WhatsApp](https://github.com/OksigeniaSL/moodle-local_oksigeniamarandu) (`local_oksigeniamarandu`,
  required) and switches on its general notice. Until then, the channel stays hidden.
- Each user joins their number in *Preferences > Notification preferences*, with the settings of the WhatsApp column:
  a private page opens WhatsApp on the phone with the message already written, or shows a QR code on a computer.
  Nothing is sent to a number that has not written to the site first, and writing the opt-out word stops everything.
- On the same page, each user switches on the notifications they want on WhatsApp. The administrator can turn kinds
  of notification off or lock them in *Site administration > Messaging > Notification settings*.
- What reaches WhatsApp is the name of the site, the subject of the notification and a button to read it on the
  site. The text of the notification stays on the site.

## Status

**Pre-alpha.** Each version is small and tested before it is released. Not for production sites.

## Install

1. Install [local_oksigeniamarandu](https://github.com/OksigeniaSL/moodle-local_oksigeniamarandu) 0.4.1 or later.
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
trademark of Meta Platforms, Inc.; this plugin is not made, endorsed or sponsored by Meta.
