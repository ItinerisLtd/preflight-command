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
            // See: https://github.com/Automattic/VIP-Coding-Standards/pull/144 about UnusedCaughtExceptions.
        } catch (ParseException $_) { // phpcs:ignore WordPressVIPMinimum.Variables.VariableAnalysis.UnusedVariable
            // Assume empty config.
            $definitions = [];
        }

        return new ConfigCollection($definitions);
    }
}
