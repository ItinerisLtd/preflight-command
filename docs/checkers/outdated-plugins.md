# outdated-plugins

Ensure all plugins are up-to-date.

::: warning
Private / premium plugins may not be checked.
:::

## Install

This checkers comes with the [preflight-command](http://github.com/itinerisltd/preflight-command) package. No extra setup steps needed.

## Config

::: warning
Changing this checker's config doesn't make sense. Use with caution!
:::

```toml
# excludes some of the plugins
[outdated-plugins]
enabled = true
excludes = [
  'sunny',
  'wordpress-seo',
  'wp-cloudflare-guard',
]

# disable it
[outdated-plugins]
enabled = false
```

## Fix

Update all WordPress plugins to latest version.
