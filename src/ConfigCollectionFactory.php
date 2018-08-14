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
            $definitions = Toml::parseFile($path);
        } catch (ParseException $parseException) {
            // Assume empty config.
            $definitions = [];
        } finally {
            return new ConfigCollection($definitions);
        }
    }
}
