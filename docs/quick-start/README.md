# Quick Start :flight_departure:

## Prerequisite

::: warning COMPATIBILITY NOTE
WP Preflight Command requires:
 - WP CLI v2.0 or later
 - PHP 7.2 or later
:::

``` bash
# upgrade wp cli
$ wp cli update

# pre-preflight checks
$ wp cli info
PHP version: 7.2.9-1
WP-CLI version: 2.0.0
```

## Install

```bash
# install
$ wp package install itinerisLtd/preflight-command:@stable
```

> PHP Fatal error: Allowed memory size of 999999 bytes exhausted
> (tried to allocate 99 bytes) #PHP Fatal error: Allowed memory
> size of 999999 bytes exhausted (tried to allocate 99 bytes)

This is a [common WP CLI issue](https://make.wordpress.org/cli/handbook/common-issues/#php-fatal-error-allowed-memory-size-of-999999-bytes-exhausted-tried-to-allocate-99-bytes). Set `memory_limit` on the fly as a temporary fix:

```bash
$ php -d memory_limit=512M "$(which wp)" package install itinerisLtd/preflight-command:@stable
```

## Usage

```bash
# run the checks
$ wp preflight check

# more info
$ wp preflight check --fields=id,status,message,description,link

# print in yaml, looks better on smaller screens
$ wp preflight check --fields=id,description,link,status,messages --format=yaml

# see all check options
$ wp help preflight check
```

You are cleared to take off. :flight_departure:
