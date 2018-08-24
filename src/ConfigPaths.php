<?php
declare(strict_types=1);

namespace Itineris\Preflight;

use function WP_CLI\Utils\normalize_path;
use function WP_CLI\Utils\trailingslashit;

class ConfigPaths
{
    public const HOOK = 'preflight_config_paths_register';

    /**
     * Returns the paths to the .toml config files.
     *
     * @return string[]
     */
    public static function all(): array
    {
        $paths = array_map(function (string $path): string {
            return normalize_path($path);
        }, apply_filters(self::HOOK, []));

        return array_values(
            array_filter($paths, function (string $path): bool {
                return is_readable($path);
            })
        );
    }

    /**
     * Register default.toml.
     *
     * Used in self::HOOK.
     *
     * @param array $paths The .toml config file paths.
     *
     * @return string[]
     */
    public static function mergeDefaultPath(array $paths): array
    {
        $paths[] = normalize_path(
            dirname(__FILE__, 2) . '/config/default.toml'
        );

        return $paths;
    }

    /**
     * Register preflight.toml under ABSPATH.
     *
     * Used in self::HOOK.
     *
     * @param array $paths The .toml config file paths.
     *
     * @return string[]
     */
    public static function mergeAbsPath(array $paths): array
    {
        if (defined('ABSPATH')) {
            $dir = constant('ABSPATH');
            $path = trailingslashit($dir) . 'preflight.toml';

            $paths[] = normalize_path($path);
        }

        return $paths;
    }

    /**
     * Register preflight.toml under PREFLIGHT_DIR.
     *
     * Used in self::HOOK.
     *
     * @param array $paths The .toml config file paths.
     *
     * @return string[]
     */
    public static function mergePreflightDir(array $paths): array
    {
        if (defined('PREFLIGHT_DIR')) {
            $dir = constant('PREFLIGHT_DIR');
            $path = trailingslashit($dir) . 'preflight.toml';

            $paths[] = normalize_path($path);
        }

        return $paths;
    }
}
