![WordPress Plugin Default Config](teaser.png)

# WordPress Security & Performance

- [About](#about)
- [How to use](#how-to-use)
- [Credits](#credits)

<br>

---

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Codeconut-Ltd_WordPress-Plugin-Default-Config&metric=alert_status)](https://sonarcloud.io/dashboard?id=Codeconut-Ltd_WordPress-Plugin-Default-Config)
![Maintenance](https://img.shields.io/static/v1?label=maintained&message=unregular&color=inactive)

<br><br>

## About

Only use if you know what you need. WordPress plugin with some hardcoded, opinionated defaults for enhanced security and reduced feature set. Generic and theme-independent implementation with a modern code style.

**Intended for developers – Not end users**

_Due to use of many 3rd party sources, this plugin is not official. Take what you need or use the setup as boilerplate for your own plugins._

<br><br>

## How to use

Copy the folder content in your WordPress directory.

#### Git workflow

Use of submodules is recommended:

`git submodule add USER:REPOSITORY wp-content/plugins/codeconutltd-global`

Call this from web root. The path must not be preceded with a slash.

<br><br>

## Credits

This plugin combines a few great public resources into one package.

### Authors

Andreas Hecht

- https://www.drweb.de/wordpress-snippets

Cloudflare

- https://blog.cloudflare.com/wordpress-pingback-attacks-and-our-waf
- https://blog.cloudflare.com/a-look-at-the-new-wordpress-brute-force-amplification-attack

WpBeginner

- https://www.wpbeginner.com/beginners-guide/vital-tips-and-tools-to-combat-comment-spam-in-wordpress
- https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file
