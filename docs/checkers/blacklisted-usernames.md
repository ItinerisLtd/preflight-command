# blacklisted-usernames

Disallow blacklisted usernames.

Not all usernames are equal. Hackers know to target certain usernames because it was the default username(**admin**) created on installation for years or just too commonly used (e.g: **root**, **webmaster**).

## Install

This checkers comes with the [preflight-command](http://github.com/itinerisltd/preflight-command) package. No extra setup steps needed.

## Config

```toml
# blacklist more usernames
[blacklisted-usernames]
blacklist = [
  'jon-snow',
  'no-one',
]

# disable it
[blacklisted-usernames]
enabled = false
```

Default config located on [`/config/default.toml`](https://github.com/ItinerisLtd/preflight-command/blob/master/config/default.toml).

## Solution

Delete those users.
