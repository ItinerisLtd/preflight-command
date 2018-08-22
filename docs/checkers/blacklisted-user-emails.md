# blacklisted-user-emails

Disallow blacklisted usernames.

## Install

This checkers comes with the [preflight-command](http://github.com/itinerisltd/preflight-command) package. No extra setup steps needed.

## Config

```toml
# blacklist more user emails
[blacklisted-user-emails]
blacklist = [
  'jon-snow@example.test',
  'no-one@example.test',
]

# disable it
[blacklisted-user-emails]
enabled = false
```

Default config located on [`/config/default.toml`](https://github.com/ItinerisLtd/preflight-command/blob/master/config/default.toml).

## Solution

Delete those users.
