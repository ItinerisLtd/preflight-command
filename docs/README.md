---
home: true
actionText: Take Off ↗
actionLink: /quick-start/
footer: MIT Licensed | Copyright © 2018-present Itineris Limited
---

<div class="features">
  <div class="feature">
    <h2>Simple</h2>
    <p>More than 30 checks just one command away. Foolproof yourself and your clients never been easier.</p>
  </div>
  <div class="feature">
    <h2>Helpful</h2>
    <p>Blaming you being a poor developer is not the goal. The command teaches you fixing the problems and enforcing best practices..</p>
  </div>
  <div class="feature">
    <h2>Extendable</h2>
    <p>Multiple actions and filters for you to inject checks and configuration, or even replace them entirely. Sky is your limit.</p>
  </div>
</div>

### As Easy as 1, 2, 3

``` bash
# install
$ wp package install itinerisLtd/preflight-command:@stable

# check mate
$ wp preflight check
+-------------------------------------+----------+
| id                                  | status   |
+-------------------------------------+----------+
| allow-indexing                      | Success  |
| blacklisted-user-emails             | Disabled |
| blacklisted-usernames               | Error    |
| inactive-plugins                    | Failure  |
| unique-salt-constants               | Success  |
| ...and many more                    | Success  |
+-------------------------------------+----------+
```

::: warning COMPATIBILITY NOTE
WP Preflight Command requires:
 - WP CLI v2.0 or later
 - PHP 7.2 or later
:::
