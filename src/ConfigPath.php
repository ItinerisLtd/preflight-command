<?php
declare(strict_types=1);

namespace Itineris\Preflight;

use WP_Error;

class ConfigPath
{
    /**
     * Returns the expected path to the preflight.toml.
     *
     * @return WP_Error|string
     */
    public static function get()
    {
        if (! defined('ABSPATH')) {
            // TODO: Test me!
            return new WP_Error("Constant 'ABSPATH' not defined. Did WordPress loaded? Aborted!");
        }

        return ABSPATH . 'preflight.toml';
    }
}
