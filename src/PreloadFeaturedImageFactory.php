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
            // @phpstan-ignore-next-line
            $config->array('preload_featured_image'),
            $container->get(PreloadImageUrlFilterInterface::class),
        );
    }
}
