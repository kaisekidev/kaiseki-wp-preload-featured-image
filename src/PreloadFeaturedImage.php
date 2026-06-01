<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\PreloadFeaturedImage;

use Kaiseki\WordPress\Hook\HookProviderInterface;

use function add_action;
use function add_filter;
use function array_key_exists;
use function esc_attr;
use function explode;
use function get_post_thumbnail_id;
use function get_post_type;
use function implode;
use function is_singular;
use function is_string;
use function remove_filter;
use function sprintf;
use function wp_get_attachment_image;

final class PreloadFeaturedImage implements HookProviderInterface
{
    /**
     * @param array<array-key, mixed>         $config
     * @param ?PreloadImageUrlFilterInterface $urlFilter
     */
    public function __construct(
        private array $config,
        private ?PreloadImageUrlFilterInterface $urlFilter = null,
    ) {
    }

    public function addHooks(): void
    {
        add_action('wp_head', [$this, 'renderPreload'], 1);
    }

    public function renderPreload(): void
    {
        if (!is_singular()) {
            return;
        }

        $postType = get_post_type();

        if ($postType === false || !array_key_exists($postType, $this->config)) {
            return;
        }

        $imageSize = $this->config[$postType];

        if (!is_string($imageSize)) {
            return;
        }

        $this->renderWithImageSize($imageSize);
    }

    private function renderWithImageSize(string $imageSize): void
    {
        $imageId = get_post_thumbnail_id();

        if ($imageId === false) {
            return;
        }

        echo $this->render($imageId, $imageSize);
    }

    public function render(int $imageId, string $imageSize): string
    {
        $imageAttr = [];

        /**
         * @param array<string, mixed> $attributes
         *
         * @return array<string, mixed>
         */
        $writeAttributeCallback = function (array $attributes) use (&$imageAttr): array {
            $imageAttr = $attributes;

            return $attributes;
        };

        add_filter(
            'wp_get_attachment_image_attributes',
            $writeAttributeCallback,
            999,
        );

        wp_get_attachment_image($imageId, $imageSize);

        remove_filter('wp_get_attachment_image_attributes', $writeAttributeCallback, 999);

        $src = $imageAttr['src'] ?? null;

        if (!is_string($src)) {
            return '';
        }

        $linkAttr = [
            'rel' => 'preload',
            'as' => 'image',
            'href' => $src,
        ];

        $srcSet = $imageAttr['srcset'] ?? null;

        if (is_string($srcSet)) {
            $linkAttr['imagesrcset'] = $this->processSrcSet($srcSet);
        }

        $sizes = $imageAttr['sizes'] ?? null;

        if (is_string($sizes)) {
            $linkAttr['imagesizes'] = $sizes;
        }

        return sprintf('<link %s>', $this->renderAttributes($linkAttr));
    }

    /**
     * @param array<string, string> $attr
     *
     * @return string
     */
    private function renderAttributes(array $attr): string
    {
        $newAttributes = [];

        foreach ($attr as $key => $value) {
            $newAttributes[$key] = sprintf('%s="%s"', $key, esc_attr($value));
        }

        return implode(' ', $newAttributes);
    }

    private function processSrcSet(string $srcSet): string
    {
        $srcSetParts = explode(', ', $srcSet);
        $newSrcSetParts = [];

        foreach ($srcSetParts as $srcSetPart) {
            [$url, $width] = explode(' ', $srcSetPart);
            $newSrcSetParts[] = sprintf(
                '%s %s',
                $this->urlFilter !== null ? ($this->urlFilter)($url) : $url,
                $width
            );
        }

        return implode(', ', $newSrcSetParts);
    }
}
