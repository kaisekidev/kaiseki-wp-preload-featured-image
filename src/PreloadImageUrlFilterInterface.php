<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\PreloadFeaturedImage;

interface PreloadImageUrlFilterInterface
{
    public function __invoke(string $url): string;
}
