<?php
declare(strict_types=1);

namespace Itineris\Preflight;

use function WP_CLI\Utils\normalize_path;
use function WP_CLI\Utils\trailingslashit;

class ConfigPath
{
    /**
     * Returns the expected path to the preflight.toml.
     *
     * @return string|null
     */
    public static function get(): ?string
    {
        $dir = null;
        if (defined('PREFLIGHT_DIR')) {
            $dir = constant('PREFLIGHT_DIR');
        } elseif (defined('ABSPATH')) {
            // TODO: Is ABSPATH checking necessary?
            $dir = constant('ABSPATH');
        }

        if (empty($dir)) {
            return null;
        }

        $path = trailingslashit($dir) . 'preflight.toml';

        return normalize_path($path);
    }
}
