<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\PreloadFeaturedImage;

final class ConfigProvider
{
    /**
     * @return array<mixed>
     */
    public function __invoke(): array
    {
        return [
            //            'preload_featured_image' => [
            //                'post' => 'large',
            //            ],
            'hook' => [
                'provider' => [
                    PreloadFeaturedImage::class,
                ],
            ],
            'dependencies' => [
                'aliases' => [],
                'factories' => [
                    PreloadFeaturedImage::class => PreloadFeaturedImageFactory::class,
                ],
            ],
        ];
    }
}
