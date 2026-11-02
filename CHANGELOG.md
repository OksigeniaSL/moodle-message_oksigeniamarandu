# Changelog

## 0.2.2 (2026-11-02)

- The notification preferences of the mobile app no longer fail with «Invalid response value detected» for a user who has
  not joined: Moodle's web service declares `userconfigured` as an integer and refused `false`.

## 0.2.1 (2026-11-01)

- The icon of Oksigenia Marandu.

## 0.2.0 (2026-10-31)

- One column for every channel, "Mobile messaging": in its settings, each user joins on WhatsApp, on Telegram or on
  both, and the notifications switched on in it reach whatever they joined. A channel to come is one more option of
  the same column. Needs local_oksigeniamarandu 0.13.0.

## 0.1.4 (2026-11-01)

- A user counts as joined with any code (these preferences, the app or a letter), and only on WhatsApp. Needs
  local_oksigeniamarandu 0.8.0.

## 0.1.3 (2026-10-31)

- The main plugin is called Oksigenia Marandu, without the channel.

## 0.1.2 (2026-10-24)

- On the narrowest phones, the names of the notifications keep their words whole: narrower switch columns, slightly
  smaller names, and breaks into syllables where the language allows.
- Spanish: «primero da de alta tu número».

## 0.1.1 (2026-10-24)

- On a phone, the notification preferences fit the screen with the WhatsApp column: before, the table spilled
  sideways and the column was out of sight.

## 0.1.0 (2026-10-24)

- The WhatsApp channel joins the notification preferences of Moodle: each user joins their number from the settings
  of the channel and chooses which notifications reach them on WhatsApp.
- Notifications go to the queue of `local_oksigeniamarandu` as its general notice: the name of the site, the subject
  and a button to read them on the site, within its limits.
- The channel stays hidden until the account of the site is connected and the general notice is switched on; its
  page in the administration says where it is set up and whether it is ready.
