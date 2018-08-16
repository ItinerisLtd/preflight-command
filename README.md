# itinerisltd/preflight-command

[![Packagist Version](https://img.shields.io/packagist/v/ItinerisLtd/preflight-command.svg)](https://packagist.org/packages/itinerisltd/preflight-command)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/ItinerisLtd/preflight-command.svg)](https://packagist.org/packages/itinerisltd/preflight-command)
[![Packagist Downloads](https://img.shields.io/packagist/dt/ItinerisLtd/preflight-command.svg)](https://packagist.org/packages/itinerisltd/preflight-command)
[![GitHub License](https://img.shields.io/github/license/itinerisltd/preflight.svg)](https://github.com/ItinerisLtd/preflight-command/blob/master/LICENSE)
[![Hire Itineris](https://img.shields.io/badge/Hire-Itineris-ff69b4.svg)](https://www.itineris.co.uk/contact/)

Check for common mistakes and enforce best practices before take off.

TODO: Write the readme!

```bash
# We need WP CLI v2
$ wp cli update

$ wp package install itinerisltd/preflight-command:@stable

$ wp help preflight
$ wp help preflight <subcommand>

$ cd /path/to/my/site

$ wp preflight checklist
$ wp preflight config validate
$ wp preflight check

$ wp preflight check --format=yaml --fields=id,status,description,messages
```

## For Itineris Team

Copy this to `<web>/web/wp/preflight.toml`:

```toml
# <web>/web/wp/preflight.toml





```

Tips: Use `$ wp preflight config edit`
