<?php
declare(strict_types=1);

namespace Itineris\Preflight;

class ConfigPath
{
    /**
     * Returns the expected path to the preflight.toml.
     *
     * @return string|null
     */
    public static function get(): ?string
    {
        if (defined('PREFLIGHT_DIR')) {
            return constant('PREFLIGHT_DIR') . 'preflight.toml';
        }

        if (defined('ABSPATH')) {
            return constant('ABSPATH') . 'preflight.toml';
        }

        return null;
    }
}
