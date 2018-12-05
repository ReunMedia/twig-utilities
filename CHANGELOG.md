# Changelog

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
