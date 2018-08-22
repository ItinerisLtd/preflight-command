# outdated-core

Ensure WordPress core is up-to-date.

## Install

This checkers comes with the [preflight-command](http://github.com/itinerisltd/preflight-command) package. No extra setup steps needed.

## Config

::: warning
Changing this checker's config doesn't make sense. Use with caution!
:::

```toml
# disable it
[outdated-core]
enabled = false
```

## Fix

Update WordPress core to latest version:

- [https://codex.wordpress.org/Updating_WordPress](https://codex.wordpress.org/Updating_WordPress)
- `$ wp core update`
