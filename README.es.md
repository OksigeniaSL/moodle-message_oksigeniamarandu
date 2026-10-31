# Mensajería móvil para las notificaciones de Moodle: WhatsApp y Telegram (Oksigenia Marandu)

[![Licencia: GPLv3](https://img.shields.io/badge/licencia-GPLv3+-blue.svg)](LICENSE)
![Moodle](https://img.shields.io/badge/Moodle-4.5%E2%80%935.3-orange)
![Estado](https://img.shields.io/badge/estado-pre--alfa-red)
[![Patrocinio](https://img.shields.io/badge/patrocinio-Oksigenia-00d4ff)](https://oksigenia.com/en/open-source#sponsor)

El canal de notificaciones de **Oksigenia Marandu**: una columna, «Mensajería móvil», en las preferencias de
notificación, junto a la web y el correo. Cada usuario se apunta por WhatsApp, por Telegram o por los dos, y elige qué
notificaciones de Moodle™ le llegan al móvil. Salen desde la cuenta oficial de WhatsApp Business del propio sitio y
desde su propio bot de Telegram, solo a quien se ha apuntado y dentro de los topes y las horas de silencio del sitio. Un
canal que venga será una opción más de la misma columna. *Marandu* es «noticia» o «aviso» en guaraní.

[Read in English](README.md)

## Cómo funciona

- El sitio conecta WhatsApp, Telegram o los dos con
  [Oksigenia Marandu](https://github.com/OksigeniaSL/moodle-local_oksigeniamarandu)
  (`local_oksigeniamarandu`, necesario) y enciende su aviso general para cada canal. Hasta entonces, la columna no se ve.
- Cada usuario se apunta en *Preferencias > Preferencias de notificación*, en los ajustes de la columna: por WhatsApp,
  una página privada abre WhatsApp en el móvil con el mensaje ya escrito, o enseña un código QR en el ordenador; por
  Telegram, se abre el bot del sitio con su código. No se manda nada a quien no haya escrito antes, y la palabra de
  baja (o bloquear el bot) lo para todo.
- En la misma página, cada usuario enciende las notificaciones que quiere recibir en el móvil. El administrador puede
  apagar o bloquear tipos de notificación en *Administración del sitio > Mensajería > Configuración de notificaciones*.
- Al móvil llegan el nombre del sitio, el asunto de la notificación y un botón para leerla en el sitio. El texto de la
  notificación se queda en el sitio.

## Estado

**Pre-alfa.** Cada versión es pequeña y se prueba antes de publicarla. No es para sitios en producción.

## Instalación

1. Instala [local_oksigeniamarandu](https://github.com/OksigeniaSL/moodle-local_oksigeniamarandu) 0.13.0 o posterior.
2. Copia este plugin en `message/output/oksigeniamarandu` de tu Moodle (de 4.5 a 5.3).
3. Entra en *Administración del sitio > Notificaciones* para terminar la instalación.

## Desarrollo

Código, comentarios y mensajes de commit en inglés; los textos, en los paquetes de idioma (`lang/en`, `lang/es`). Las
pruebas se lanzan con `moodle-plugin-ci` en GitHub Actions sobre Moodle 4.5 y 5.3 (PostgreSQL) y sobre 5.3 con
MariaDB 11.4. Mira [CONTRIBUTING.md](CONTRIBUTING.md).

## Licencia

GNU GPL v3 o posterior. Mira [LICENSE](LICENSE).

© 2026 Oksigenia SL — dev@oksigenia.cc

La palabra Moodle y los logotipos asociados son marcas comerciales o registradas de Moodle Pty Ltd o sus filiales.
Oksigenia no está afiliada a Moodle HQ y no es Moodle Certified Partner. WhatsApp es una marca de Meta Platforms, Inc.
Este plugin no está hecho, respaldado ni patrocinado por Meta ni por Telegram.
