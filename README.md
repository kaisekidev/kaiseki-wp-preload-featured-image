# kaiseki/wp-preload-featured-image

Preloads the featured image of singular WordPress posts via a `rel=preload` link tag, with optional CDN URL rewriting.

On `wp_head`, for configured post types, this emits a `<link rel="preload" as="image">` for the post's
featured image (including its responsive `imagesrcset` / `imagesizes`), so the browser can start
fetching the LCP image earlier. It is wired as a `kaiseki/wp-hook` `HookProviderInterface` through
`ConfigProvider` — enable it by adding its config and registering the provider, no manual
`add_action` plumbing.

## Installation

```bash
composer require kaiseki/wp-preload-featured-image
```

Requires PHP 8.2 or newer.

## Usage

Register `ConfigProvider` with your laminas-style config aggregator, then map each post type to the
image size to preload via the `preload_featured_image` config key:

```php
use Kaiseki\WordPress\PreloadFeaturedImage\PreloadFeaturedImage;

return [
    // post type => registered image size to preload
    'preload_featured_image' => [
        'post' => 'large',
        'page' => 'full',
    ],
    // Activate the provider via kaiseki/wp-hook.
    'hook' => [
        'provider' => [
            PreloadFeaturedImage::class,
        ],
    ],
];
```

`ConfigProvider` registers the `PreloadFeaturedImageFactory`, which reads the `preload_featured_image`
map from the container. On a singular page whose post type is in the map, the featured image is
preloaded at the configured size.

### Rewriting the preloaded URL (CDN)

The `imagesrcset` URLs can be rewritten through an optional `PreloadImageUrlFilterInterface`. The
package ships `RocketCdnFilter`, which routes URLs through WP Rocket's `get_rocket_cdn_url()` when the
plugin is active (and is a no-op otherwise). Bind it — or your own implementation — in the container:

```php
use Kaiseki\WordPress\PreloadFeaturedImage\PreloadImageUrlFilterInterface;
use Kaiseki\WordPress\PreloadFeaturedImage\RocketCdnFilter;

return [
    'dependencies' => [
        'aliases' => [
            PreloadImageUrlFilterInterface::class => RocketCdnFilter::class,
        ],
    ],
];
```

```php
use Kaiseki\WordPress\PreloadFeaturedImage\PreloadImageUrlFilterInterface;

final class MyCdnFilter implements PreloadImageUrlFilterInterface
{
    public function __invoke(string $url): string
    {
        return str_replace('https://example.com', 'https://cdn.example.com', $url);
    }
}
```

## Development

```bash
composer install
composer check   # check-deps, cs-check, phpstan
```

## License

MIT — see [LICENSE](LICENSE.md).
