<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\PreloadFeaturedImage;

use Kaiseki\Config\Config;
use Psr\Container\ContainerInterface;

final class PreloadFeaturedImageFactory
{
    public function __invoke(ContainerInterface $container): PreloadFeaturedImage
    {
        $config = Config::fromContainer($container);

        return new PreloadFeaturedImage(
            $config->array('preload_featured_image'),
            $container->has(PreloadImageUrlFilterInterface::class)
                ? $container->get(PreloadImageUrlFilterInterface::class)
                : null,
        );
    }
}
