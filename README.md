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

$ wp preflight check --fields=id,status,message,description,link
$ wp preflight check --fields=id,description,link,status,messages --format=yaml
```

## `preflight.toml`

Default location is `ABSPATH . 'preflight.toml'`

Customizable by `PREFLIGHT_DIR`.

If `PREFLIGHT_DIR` constant is defined, we look for `PREFLIGHT_DIR . 'preflight.toml'`. 

Tips: `$ wp preflight config path`

### Normal WP

```php
// wp-config.php

// One level up from `wp-config.php`
define( 'PREFLIGHT_DIR', dirname( __FILE__, 2 ));

// One level up from `wp-config.php`
define( 'PREFLIGHT_DIR', '/absolute/path/to/the/dir/' );
```

### Bedrock

This means `<bedrock>/config/preflight.toml`:

```php
// <bedrock>/config/application.php

Config::define('PREFLIGHT_DIR', __DIR__);
```

### Old Bedrock without `roots/wp-config`

This means `<bedrock>/config/preflight.toml`:

```php
// <bedrock>/config/application.php

// Not recommanded. Update Bedrock!!!!
define('PREFLIGHT_DIR', __DIR__);
```

## For Itineris Team

Tips: 
- `$ wp help preflight config`
- `$ wp preflight config validate`

Put this (`preflight.toml`) under `PREFLIGHT_DIR` or `ABSPATH`:

```toml
# preflight.toml

# Use TOML v0.4.0 syntax
# See: https://github.com/toml-lang/toml/blob/master/versions/en/toml-v0.4.0.md

# TOML v0.5.0 not yet supported

# Use expected production URL (i.e: client's URL)
# Starts with 'https://'
[production-site-url]
url = 'https://preflightcommand.local/'

[production-home-url]
url = 'https://preflightcommand.local'

# Everything above is mandatory
# -----------------------------
# Everything below is example
# All of them are optional
# Remove if possible

[blacklisted-usernames]
blacklist = [
  'itineris',
  'tim',
]
whitelist = [
  'root',
]

[blacklisted-user-emails]
blacklist = [
  'hello@itineris.co.uk',
]
whitelist = [
  'root@example.test',
]

# This is default. Remove if possible
[sitemap]
path = '/sitemap_index.xml' # Yoast SEO
```

### For Itineris Team

```bash
$ composer test
$ composer check-style
```

Pull requests without tests will not be accepted!
