# Changelog

## v0.6.0 - 2019-01-07
### New features
- `CopyrightYear` function.

## v0.5.3 - 2018-12-06
### Bugfixes
- Fix case sensitivity bug by renaming `HtmlPurify.php` to `Htmlpurify.php`.

## v0.5.2 - 2018-12-06
### Bugfixes
- Fix `TwigNotFoundHandler`

## v0.5.1 - 2018-12-06
This release introduces a temporary fix for Slim component not working with
PHP-DI.

Currently PHP-DI doesn't support `class_alias()`, which means that
`Twig_Environment` gets injected instead of `Twig\Environment`. To fix this all
classes depending on `Twig\Environment` have been changed to use
`Twig_Environment` instead. They might be changed back in the future once PHP-DI
gets fixed. See http://bit.ly/2SsA5Rh for the issue.

## v0.5.0 - 2018-12-05
### Breaking changes
Pretty much everything has changed. Backwards incompatible with previous
version. Repository got messed up. Had to rebase. Previous versions might not
be available anymore (missing tags).

### New features
- Slim component with various Slim Twig integration helpers.
- New filters: HtmlPurify, RemoveEmpty.
- Refactor TwigExtension

## v0.4.0 - 2018-10-15
### New features
#### FormatDateRange
- Now accepts `DateTime` objects in addition to strings.
- Can now specify a custom delimiter string (default `-`)

## v0.3.0 - 2018-05-02
### New features
- `FormatDateRange`: Option to always include year in the returned date.

## v0.2.0 - 2018-04-24
### New features
- Add `strftime` filter.

## v0.1.0 - 2018-04-24
Initial release.
