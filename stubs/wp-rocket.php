<?php

/**
 * PHPStan stub for the WP Rocket plugin.
 *
 * WP Rocket is an optional runtime dependency — `RocketCdnFilter` calls
 * `get_rocket_cdn_url()` only behind a `function_exists()` guard — so it is not a
 * Composer requirement. This file is referenced via PHPStan `scanFiles` (not the
 * Composer autoloader), purely to give static analysis the function's signature so
 * the `use function` import resolves.
 *
 * The declaration is guarded and returns the URL unchanged so that, even if this
 * file were ever loaded at runtime, it cannot trigger a redeclare fatal (when WP
 * Rocket is present) or a TypeError (empty body vs. the `string` return type).
 *
 * @see https://docs.wp-rocket.me/
 */

if (!function_exists('get_rocket_cdn_url')) {
    /**
     * @param array<string, mixed> $args
     */
    function get_rocket_cdn_url(string $url, array $args = []): string
    {
        return $url;
    }
}
