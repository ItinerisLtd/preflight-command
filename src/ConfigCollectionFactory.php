<?php
declare(strict_types=1);

namespace Itineris\Preflight;

use Yosymfony\Toml\Exception\ParseException;
use Yosymfony\Toml\Toml;

class ConfigCollectionFactory
{
    /**
     * Parses the TOML and returns a config instance.
     *
     * @param string $path Path to the TOML.
     *
     * @return ConfigCollection
     */
    public static function makeFromFile(string $path): ConfigCollection
    {
        try {
            // Toml::parseFile might return void.
            $definitions = (array) Toml::parseFile($path);

            // See: Automattic/VIP-Coding-Standards#144 on Github.
            // phpcs:ignore WordPressVIPMinimum.Variables.VariableAnalysis.UnusedVariable
        } catch (ParseException $_) {
            // Assume empty config.
            $definitions = [];
        }

        return new ConfigCollection($definitions);
    }
}
