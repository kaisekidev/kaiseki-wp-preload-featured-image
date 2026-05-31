<?php

/**
 * PHPStan stub for the WP Rocket plugin.
 *
 * WP Rocket is an optional runtime dependency — `RocketCdnFilter` calls
 * `get_rocket_cdn_url()` only behind a `function_exists()` guard — so it is not a
 * Composer requirement. This stub gives PHPStan the function's signature (so the
 * `use function` import resolves) without pulling in the plugin.
 *
 * @see https://docs.wp-rocket.me/
 *
 * @param array<string, mixed> $args
 */
function get_rocket_cdn_url(string $url, array $args = []): string {}
