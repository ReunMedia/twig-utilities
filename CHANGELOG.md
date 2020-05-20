# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.9.1] - 2020-05-20
### Fixed
- Error when calling `CopyrightYear` with only starting year.

## [0.9.0] - 2020-04-14
### Added
- StaticTwigPage Slim action.
- Some tests.

### Changed
- `CopyrightYear`: Now accepts an optional end date.
- `FormatDateRange`: Add period at the end of dates without a year.

## [0.8.0] - 2020-02-11
This release introduces multiple major breaking changes. See updated
[README](README.md) for new usage instructions.

### Breaking Changes
- Requires PHP 7.4.
- Requires Twig 3.0.
- Requires Slim 4.0 for Slim related features.
- Removed `removeEmpty` filter. Use `|filter(v => v)` or define `array_filter`
  as a filter in your extension instead.
- Removed `PhpDebugBar` extension. Use a PSR middleware such as
  `php-middleware/debugbar` or `middlewares/debugbar` instead.
- Removed `TwigLoaderError` middleware. `TwigLoaderErrorHandler` should be used
  instead. Usage instructions are in [README](README.md#handling-not-found-errors).

### Changed
- Use Reun Media dotfiles and other conventions from `generator-reun-webapp`.

### Fixed
- `FormatDateRange` now always displays a year on both dates if they are on a
  different year.

## [0.7.0] - 2019-02-13
### Added
- Add PHP Debug Bar extension.

## [0.6.0] - 2019-01-07
### Added
- `CopyrightYear` function.

## [0.5.3] - 2018-12-06
### Bugfixes
- Fix case sensitivity bug by renaming `HtmlPurify.php` to `Htmlpurify.php`.

## [0.5.2] - 2018-12-06
### Bugfixes
- Fix `TwigNotFoundHandler`

## [0.5.1] - 2018-12-06
This release introduces a temporary fix for Slim component not working with
PHP-DI.

Currently PHP-DI doesn't support `class_alias()`, which means that
`Twig_Environment` gets injected instead of `Twig\Environment`. To fix this all
classes depending on `Twig\Environment` have been changed to use
`Twig_Environment` instead. They might be changed back in the future once PHP-DI
gets fixed. See http://bit.ly/2SsA5Rh for the issue.

## [0.5.0] - 2018-12-05
### Breaking changes
Pretty much everything has changed. Backwards incompatible with previous
version. Repository got messed up. Had to rebase. Previous versions might not
be available anymore (missing tags).

### Added
- Slim component with various Slim Twig integration helpers.
- New filters: HtmlPurify, RemoveEmpty.
- Refactor TwigExtension

## [0.4.0] - 2018-10-15
### Added
#### FormatDateRange
- Now accepts `DateTime` objects in addition to strings.
- Can now specify a custom delimiter string (default `-`)

## [0.3.0] - 2018-05-02
### Added
- `FormatDateRange`: Option to always include year in the returned date.

## [0.2.0] - 2018-04-24
### Added
- Add `strftime` filter.

## [0.1.0] - 2018-04-24
Initial release.
