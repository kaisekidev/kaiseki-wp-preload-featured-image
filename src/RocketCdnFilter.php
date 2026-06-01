<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\PreloadFeaturedImage;

use function function_exists;
use function get_rocket_cdn_url;

final class RocketCdnFilter implements PreloadImageUrlFilterInterface
{
    public function __invoke(string $url): string
    {
        return function_exists('get_rocket_cdn_url') ? get_rocket_cdn_url($url) : $url;
    }
}
