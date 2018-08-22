# inactive-plugins

Ensure all plugins are activated.

Inactive plugins are dead code. Although they never been ran, keeping them on the server introduce security concerns.

## Install

This checkers comes with the [preflight-command](http://github.com/itinerisltd/preflight-command) package. No extra setup steps needed.

## Config

::: warning
Changing this checker's config doesn't make sense. Use with caution!
:::

```toml
# excludes some of the plugins
[inactive-plugins]
enabled = true
excludes = [
  'sunny',
  'wordpress-seo',
  'wp-cloudflare-guard',
]

# disable it
[inactive-plugins]
enabled = false
```

## Fix

- activate the plugins
- uninstall the plugins
