# robots-txt

Ensure robots.txt is 200 OK.

> Robots.txt is a text file webmasters create to instruct web robots (typically search engine robots) how to crawl pages on their website. The robots.txt file is part of the the robots exclusion protocol (REP), a group of web standards that regulate how robots crawl the web, access and index content, and serve that content up to users.
>
> -- [What is robots.txt?](https://moz.com/learn/seo/robotstxt)

## Install

This checkers comes with the [preflight-command](http://github.com/itinerisltd/preflight-command) package. No extra setup steps needed.

## Config

::: warning
Changing this checker's config doesn't make sense. Use with caution!
:::

```toml
# disable it
[robots-txt]
enabled = false
```

## Solution

Upload [robots.txt](https://support.google.com/webmasters/answer/6062596?hl=en) to web root.
