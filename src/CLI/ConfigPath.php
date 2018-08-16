<?php
declare(strict_types=1);

namespace Itineris\Preflight\CLI;

use Itineris\Preflight\ConfigPath as BaseConfigPath;
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
        $path = BaseConfigPath::get();

        if (empty($path)) {
            WP_CLI::error(
                "Both 'PREFLIGHT_DIR' and 'ABSPATH' constants not defined. Unable to find 'preflight.toml'"
            );
        }

        return $path;
    }
}
