# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 1.0.0 - 2026-05-31

First tagged release.

### Added

- `PreloadFeaturedImage` hook provider — emits a `<link rel="preload" as="image">` (with responsive
  `imagesrcset` / `imagesizes`) for the featured image of singular posts whose post type is listed in
  the `preload_featured_image` config map.
- `PreloadImageUrlFilterInterface` with the `RocketCdnFilter` implementation for routing preloaded
  URLs through WP Rocket's CDN, plus `ConfigProvider` and `PreloadFeaturedImageFactory` for wiring.

### Changed

- PHP requirement is `^8.2` (PHP 8.4 is the primary target).
- Modernized the dev toolchain (PHPStan 2, PHPUnit 11 schema, composer-require-checker 4) and depend
  on `kaiseki/php-coding-standard: ^1.0` with the shared PHPStan config; `kaiseki/config` and
  `kaiseki/wp-hook` pinned to `^2.0`. CI now runs via the reusable workflow in `kaisekidev/.github`.

### Fixed

- Removed `@phpstan-ignore` suppressions: the config map is now typed `array<array-key, mixed>` and
  narrowed at the point of use, and `get_rocket_cdn_url()` is resolved through a PHPStan stub instead
  of being ignored. No runtime behaviour change.
