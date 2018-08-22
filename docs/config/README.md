# Config

::: warning
Use TOML [v0.4.0 syntax](https://github.com/toml-lang/toml/blob/master/versions/en/toml-v0.4.0.md) only.

TOML v0.5.0 not yet supported.
:::

## preflight.toml

Although the package comes with a [sane default configuration](https://github.com/ItinerisLtd/preflight-command/tree/master/config), nothing stops you from customizing it for your specific needs.

A `preflight.toml` looks like this:

```toml
[my-checker-id-1]
enabled = false

[my-checker-id-2]
blacklist = [
  'bad-1',
  'bad-2',
]
whitelist = [
  'remove-me-from-blacklist',
]

[my-checker-id-3]
includes = [
  'must-have-1',
  'must-have-2',
]
excludes = [
  'remove-me-from-includes',
]
```

Learn more about [checker configuration](../checkers/README.md).

## Where to put `preflight.toml`?

By default, the package looks for `preflight.toml` under `ABSPATH`, usually this mean same level with `wp-config.php`.

```
/my/htdocs/wordpress
├── ...
├── preflight.toml
└── wp-config.php
```

### PREFLIGHT_DIR

::: tip NOTE
If `preflight.toml` were found under both `ABSPATH` and `PREFLIGHT_DIR` at the same time, the `PREFLIGHT_DIR` one has higher priority.
:::

For [Bedrock](https://github.com/root/bedrock/) or other custom WordPress structures, which not suitable for adding config files under `ABSPATH`. You can use `PREFLIGHT_DIR` to define an alternative path.

```php
define('PREFLIGHT_DIR', '/my/absolute/path');
```

The package looks for `/my/absolute/path/preflight.toml`.

## $ wp preflight config paths

```bash
# get the paths to all config files
$ wp preflight config paths
Success: 3 config files found.
Success: The later ones override any previous configurations.
/root/.wp-cli/packages/vendor/itinerisltd/preflight-command/config/default.toml
/app/public/preflight.toml
/app/preflight.toml
```

## TOML

Key Points:

- file extension is `.toml` (e.g: `preflight.toml`)
- TOML is case sensitive
- empty array is invalid
- indentation doesn't matter
- tabs or spaces doesn't matter

Learn more about TOML on its [GitHub repo](https://github.com/toml-lang/toml).

## $ wp preflight config validate

::: tip NOTE
Any invalid TOML files are ignored through out the package.

Empty and comment-only files are considered as valid.
:::

Worry not. We check your config files as well.

```bash
# validate all the config files including the package default ones
$ wp preflight config validate
====> Validating /root/.wp-cli/packages/vendor/itinerisltd/preflight-command/config/default.toml
Success: File '/root/.wp-cli/packages/vendor/itinerisltd/preflight-command/config/default.toml' is valid.

====> Validating /app/public/preflight.toml

  Syntax error: unexpected token "T_NEWLINE" at line 2 with value "". Expected "T_RIGHT_SQUARE_BRAKET" in "\/app\/public\/preflight.toml".

Warning: File '/app/public/preflight.toml' will be ignored.
```
