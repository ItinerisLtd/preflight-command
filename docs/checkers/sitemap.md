# sitemap

Ensure sitemap is 200 OK.

> What is a sitemap?
>
> A sitemap is a file where you can list the web pages of your site to tell Google and other search engines about the organization of your site content. Search engine web crawlers like Googlebot read this file to more intelligently crawl your site.
>
> Also, your sitemap can provide valuable metadata associated with the pages you list in that sitemap: Metadata is information about a webpage, such as when the page was last updated, how often the page is changed, and the importance of the page relative to other URLs in the site.
>
> -- [What is a sitemap?](https://support.google.com/webmasters/answer/156184?hl=en)

## Install

This checkers comes with the [preflight-command](http://github.com/itinerisltd/preflight-command) package. No extra setup steps needed.

## Config

```toml
# this means https://example.com/my-sitemap.xml
[sitemap]
path = '/my-sitemap.xml'

# disable it
[sitemap]
enabled = false
```

Default config located on [`/config/default.toml`](https://github.com/ItinerisLtd/preflight-command/blob/master/config/default.toml).

## Solution

Lots of plugins generates sitemaps for you:

- [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/)
- [Google XML Sitemaps](https://wordpress.org/plugins/google-sitemap-generator/)
- [All in One SEO Pack](https://wordpress.org/plugins/all-in-one-seo-pack/)

Other than XML, Google accepts RSS, mRSS, Atom 1.0 and even a simple text file. As long as your `path` is `200 OK`, this checker passes.
