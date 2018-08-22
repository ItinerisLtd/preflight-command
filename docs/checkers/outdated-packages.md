# outdated-packages

::: warning
Bundled packages might not be checked.
:::

Ensure all WP CLI packages are up-to-date.

## Install

This checkers comes with the [preflight-command](http://github.com/itinerisltd/preflight-command) package. No extra setup steps needed.

## Config

::: warning
Changing this checker's config doesn't make sense. Use with caution!
:::

```toml
# excludes some of the packages
[outdated-packages]
enabled = true
excludes = [
  'aaemnnosttv/wp-cli-login-command',
  'wp-cli/config-command',
]

# disable it
[outdated-packages]
enabled = false
```

## Fix

Run `$ wp package update`
