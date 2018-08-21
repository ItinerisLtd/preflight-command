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
     * @param string|string[] ...$paths Paths to TOML files.
     *
     * @return ConfigCollection
     */
    public static function makeFromFiles(string ...$paths): ConfigCollection
    {
        $definitions = array_map(function (string $path): array {
            try {
                // Toml::parseFile might return void / null.
                $definitions = (array) Toml::parseFile($path);

                // See: Automattic/VIP-Coding-Standards#144 on Github.
                // phpcs:ignore WordPressVIPMinimum.Variables.VariableAnalysis.UnusedVariable
            } catch (ParseException $_parseException) {
                // Assume empty config.
                $definitions = [];
            }

            return $definitions;
        }, $paths);

        $mergedDefinitions = array_reduce($definitions, function (array $merged, array $definition): array {
            return self::arrayMergeRecursiveDistinct($merged, $definition);
        }, []);

        return new ConfigCollection($mergedDefinitions);
    }

    /**
     * This does not change the data types of the values in the arrays. Matching keys' values in the second array
     * overwrite those in the first array, as is the case with array_merge.
     *
     * This is modified from an example on php.net.
     *
     * @see https://secure.php.net/manual/en/function.array-merge-recursive.php#92195
     *
     * @param array $merged The first array.
     * @param array $other  The second array.
     *
     * @return array
     */
    private static function arrayMergeRecursiveDistinct(array $merged, array $other): array
    {
        foreach ($other as $key => $value) {
            if (is_array($value) && is_array($merged[$key] ?? [])) {
                $merged[$key] = self::arrayMergeRecursiveDistinct($merged[$key] ?? [], $value);
            } elseif (is_int($key)) {
                // Avoid arrays being overridden.
                $merged = array_unique(
                    array_merge($merged, [$value])
                );
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }
}
