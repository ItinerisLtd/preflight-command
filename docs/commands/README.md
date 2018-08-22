# Commands

::: tip THERE ARE MORE
This page only shows a handful of basic usages. The `help` command is your friend:

```bash
$ wp help preflight

# even more details
# wp help preflight <command>
# wp help preflight <command> <subcommand>
$ wp help preflight check
$ wp help preflight config
$ wp help preflight config paths
$ wp help preflight config validate
$ wp help preflight checklist
```
:::

## $ wp preflight check

This command runs all the registered checkers and prints a report. Your goal is to get `Success` on all checks.

```bash
$ wp preflight check
+-------------------------------------+----------+
| id                                  | status   |
+-------------------------------------+----------+
| allow-indexing                      | Success  |
| outdated-packages                   | Failure  |
| required-salt-constants             | Error    |
| secure-home-url                     | Disabled |
+-------------------------------------+----------+
```

Get more details with the `message` field when you encounter an `Error` or `Failure`.

```bash
$ wp preflight check --fields=id,status,message
```

Not everyone has an Airbus A380, printing the report in yaml works better on smaller screens.

```bash
$ wp preflight check --fields=id,description,link,status,messages --format=yaml
```

To see all available options:

```bash
$ wp help preflight check
```

## $ wp preflight checklist

Lists all registered [checkers](../checkers/README.md) (without running them).

```bash
$ wp preflight checklist

# in yaml format, for smaller screens
$ wp preflight checklist --format=yaml
```

## $ wp preflight config

Reads and validates all the `preflight.toml` config files including the packages ones (i.e: the default config).

```bash
# print the content of all config files
$ wp preflight config cat

# get the paths to all config files
$ wp preflight config paths

# validate the TOML syntax
$ wp preflight config validate
```

Learn more about [config files](../config/README.md).

## Misc

```bash
# install, `:@stable` is important
$ wp package install itinerisltd/preflight-command:@stable

# install more checkers
# you might not need them all, check their documents
$ wp package install itinerisltd/preflight-extra:@stable
$ wp package install itinerisltd/preflight-yoast-seo:@stable

# update
$ wp package update
```
