# Change Log

## [0.3.0](https://github.com/ItinerisLtd/preflight-command/tree/0.3.0) (2018-08-18)
[Full Changelog](https://github.com/ItinerisLtd/preflight-command/compare/0.2.0...0.3.0)

**Merged pull requests:**

- Rename: `Defined` --\> `Required` [\#37](https://github.com/ItinerisLtd/preflight-command/pull/37) ([TangRufus](https://github.com/TangRufus))
- ConfigPath: trailing slash and normalize path [\#36](https://github.com/ItinerisLtd/preflight-command/pull/36) ([TangRufus](https://github.com/TangRufus))
- Ensure result messages are strings [\#35](https://github.com/ItinerisLtd/preflight-command/pull/35) ([TangRufus](https://github.com/TangRufus))
- Add `Checkers/OutdatedPackages` [\#33](https://github.com/ItinerisLtd/preflight-command/pull/33) ([TangRufus](https://github.com/TangRufus))
- Ensure `wp-cli/core-command` and `wp-cli/extension-command` installed [\#32](https://github.com/ItinerisLtd/preflight-command/pull/32) ([TangRufus](https://github.com/TangRufus))
- Add `Checkers/AllowIndexing` [\#31](https://github.com/ItinerisLtd/preflight-command/pull/31) ([TangRufus](https://github.com/TangRufus))
- Add `Checkers/OutdatedCore` [\#30](https://github.com/ItinerisLtd/preflight-command/pull/30) ([TangRufus](https://github.com/TangRufus))
- Refactor checker traits [\#29](https://github.com/ItinerisLtd/preflight-command/pull/29) ([TangRufus](https://github.com/TangRufus))
- Add `Checkers/RequiredPlugins` [\#28](https://github.com/ItinerisLtd/preflight-command/pull/28) ([TangRufus](https://github.com/TangRufus))
- Rename: `LatestPlugins` -\> `OutdatedPlugins` [\#27](https://github.com/ItinerisLtd/preflight-command/pull/27) ([TangRufus](https://github.com/TangRufus))
- Add `Checkers/InactivePlugins` [\#26](https://github.com/ItinerisLtd/preflight-command/pull/26) ([TangRufus](https://github.com/TangRufus))
- Add `Checkers/LatestPlugins` [\#25](https://github.com/ItinerisLtd/preflight-command/pull/25) ([TangRufus](https://github.com/TangRufus))
- Extract `ValidatorAwareTrait` [\#24](https://github.com/ItinerisLtd/preflight-command/pull/24) ([TangRufus](https://github.com/TangRufus))
- `RobotsTxt` and `Sitemap` display `WP\_Error` messages [\#23](https://github.com/ItinerisLtd/preflight-command/pull/23) ([TangRufus](https://github.com/TangRufus))
- Extract `AbstractValidator` and add `DefinedConstants` [\#21](https://github.com/ItinerisLtd/preflight-command/pull/21) ([TangRufus](https://github.com/TangRufus))
- Allow config be customizable by `PREFLIGHT\_DIR` [\#20](https://github.com/ItinerisLtd/preflight-command/pull/20) ([TangRufus](https://github.com/TangRufus))
- Expand `ResultInterface::toArray` and `CheckerInterface::toArray` [\#19](https://github.com/ItinerisLtd/preflight-command/pull/19) ([TangRufus](https://github.com/TangRufus))

## [0.2.0](https://github.com/ItinerisLtd/preflight-command/tree/0.2.0) (2018-08-16)
[Full Changelog](https://github.com/ItinerisLtd/preflight-command/compare/0.1.0...0.2.0)

**Merged pull requests:**

- Version bump 0.2.0 [\#18](https://github.com/ItinerisLtd/preflight-command/pull/18) ([TangRufus](https://github.com/TangRufus))
- Bikeshedding Round 3 [\#17](https://github.com/ItinerisLtd/preflight-command/pull/17) ([TangRufus](https://github.com/TangRufus))
- Add `ProductionHomeUrl` and `ProductionSiteUrl` [\#16](https://github.com/ItinerisLtd/preflight-command/pull/16) ([TangRufus](https://github.com/TangRufus))
- Bikeshedding again [\#15](https://github.com/ItinerisLtd/preflight-command/pull/15) ([TangRufus](https://github.com/TangRufus))
- Extract `BlacklistedUsernames` and `BlacklistedUserEmails` [\#14](https://github.com/ItinerisLtd/preflight-command/pull/14) ([TangRufus](https://github.com/TangRufus))
- Add `HttpsHomeUrl` and `HttpsSiteUrl` checkers [\#13](https://github.com/ItinerisLtd/preflight-command/pull/13) ([TangRufus](https://github.com/TangRufus))
- Create LICENSE [\#11](https://github.com/ItinerisLtd/preflight-command/pull/11) ([TangRufus](https://github.com/TangRufus))
- Bikeshedding [\#10](https://github.com/ItinerisLtd/preflight-command/pull/10) ([TangRufus](https://github.com/TangRufus))
- Add `DefinedSaltConstants` and `UniqueSaltConstants` [\#9](https://github.com/ItinerisLtd/preflight-command/pull/9) ([TangRufus](https://github.com/TangRufus))
- Add `Checkers/Sitemap` [\#8](https://github.com/ItinerisLtd/preflight-command/pull/8) ([TangRufus](https://github.com/TangRufus))
- Add `Checkers/RobotsTxt` [\#7](https://github.com/ItinerisLtd/preflight-command/pull/7) ([TangRufus](https://github.com/TangRufus))
- Apply code style [\#6](https://github.com/ItinerisLtd/preflight-command/pull/6) ([TangRufus](https://github.com/TangRufus))
- Refactor: Results accept multi-line messages  [\#5](https://github.com/ItinerisLtd/preflight-command/pull/5) ([TangRufus](https://github.com/TangRufus))
- Extract `CheckerCollectionPresenter` [\#4](https://github.com/ItinerisLtd/preflight-command/pull/4) ([TangRufus](https://github.com/TangRufus))

## [0.1.0](https://github.com/ItinerisLtd/preflight-command/tree/0.1.0) (2018-08-14)
**Merged pull requests:**

- Version bump 0.1.0 [\#3](https://github.com/ItinerisLtd/preflight-command/pull/3) ([TangRufus](https://github.com/TangRufus))
- First release [\#2](https://github.com/ItinerisLtd/preflight-command/pull/2) ([TangRufus](https://github.com/TangRufus))



\* *This Change Log was automatically generated by [github_changelog_generator](https://github.com/skywinder/Github-Changelog-Generator)*