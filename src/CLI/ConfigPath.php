<?php
declare(strict_types=1);

namespace Itineris\Preflight\CLI;

use Itineris\Preflight\ConfigPath as TomlPath;
use WP_CLI;

class ConfigPath
{
    /**
     * Gets the expected path to the preflight.toml.
     *
     * @return string Expected path to preflight.toml file
     */
    public static function get(): string
    {
        $path = TomlPath::get();

        if (is_wp_error($path)) {
            WP_CLI::error($path);
        }

        return $path;
    }
}
