# required-salt-constants

Ensure required salt constants are defined.

> A secret key makes your site harder to hack by adding random elements to the password.
>
> In simple terms, a secret key is a password with elements that make it harder to generate enough options to break through your security barriers. A password like "password" or "test" is simple and easily broken. A random, long password which uses no dictionary words, such as "88a7da62429ba6ad3cb3c76a09641fc" would take a brute force attacker millions of hours to crack. A 'salt is used to further enhance the security of the generated result.
>
> -- [WordPress Codex](https://codex.wordpress.org/Editing_wp-config.php#Security_Keys)

## Install

This checkers comes with the [preflight-command](http://github.com/itinerisltd/preflight-command) package. No extra setup steps needed.

## Config

::: warning
Changing this checker's config doesn't make sense. Use with caution!
:::

```toml
# excludes some of the salt constants
[required-salt-constants]
enabled = true
excludes = [
  'AUTH_KEY',
  'SECURE_AUTH_KEY',
]

# disable it
[required-salt-constants]
enabled = false
```

Default config located on [`/config/default.toml`](https://github.com/ItinerisLtd/preflight-command/blob/master/config/default.toml).

## Solution

Define unique salt constants.

- copy from [WordPress salt generator](https://api.wordpress.org/secret-key/1.1/salt) to `wp-config.php`
- `$ wp config shuffle-salts`
