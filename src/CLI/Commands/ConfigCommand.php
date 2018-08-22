<?php
declare(strict_types=1);

namespace Itineris\Preflight\CLI\Commands;

use Itineris\Preflight\ConfigPaths;
use WP_CLI;
use WP_CLI_Command;
use Yosymfony\Toml\Exception\ParseException;
use Yosymfony\Toml\Toml;

/**
 * Reads and validates the preflight.toml config files.
 */
class ConfigCommand extends WP_CLI_Command
{
    /**
     * Gets the paths to all config files.
     *
     * ## EXAMPLES
     *
     *     # Get preflight.toml file paths
     *     $ wp preflight config paths
     *     Success: 3 config files found.
     *     Success: The later ones override any previous configurations.
     *     /x/.wp-cli/packages/vendor/y/z/config/default.toml
     *     /app/public/preflight.toml
     *     /app/preflight.toml
     *
     *     # When paths not found
     *     $ wp preflight config paths
     *     wp preflight config paths
     *     No config file found.
     *     Perhaps 'preflight_config_paths_register' not filtering properly?
     *     Error: Abort!
     */
    public function paths(): void
    {
        $paths = $this->getConfigPaths();

        WP_CLI::success(count($paths) . ' config files found.');
        WP_CLI::success('The later ones override any previous configurations.');

        foreach ($paths as $path) {
            WP_CLI::log($path);
        }
    }

    protected function getConfigPaths(): array
    {
        $paths = ConfigPaths::all();

        if (count($paths) < 1) {
            WP_CLI::error_multi_line([
                'No config file found.',
                "Perhaps '" . ConfigPaths::HOOK . "' not filtering properly?",
            ]);

            WP_CLI::error('Abort!');
        }

        return $paths;
    }

    /**
     * Prints the content of all config files.
     *
     * ## EXAMPLES
     *
     *     # Print the content of all config files
     *     $ wp preflight config cat
     */
    public function cat(): void
    {
        $paths = $this->getConfigPaths();

        foreach ($paths as $path) {
            WP_CLI::line(
                WP_CLI::colorize("%B====> Printing $path%n")
            );

            // phpcs:ignore WordPressVIPMinimum.VIP.FetchingRemoteData.fileGetContentsUknown
            $contents = file_get_contents($path);

            $contentsWithoutLineBreaks = str_replace(["\r", "\n"], '', $contents);
            if (empty($contentsWithoutLineBreaks)) {
                WP_CLI::error_multi_line([
                    "File '$path' is empty.",
                ]);
            }

            WP_CLI::line($contents);
            // Print a empty line for better UX.
            WP_CLI::line('');
        }
    }

    /**
     * Validates the TOML syntax of all config files.
     *
     * ## EXAMPLES
     *
     *     # Validate the TOML syntax of the config files
     *     $ wp preflight config validate
     */
    public function validate(): void
    {
        $paths = $this->getConfigPaths();

        foreach ($paths as $path) {
            WP_CLI::line(
                WP_CLI::colorize("%B====> Validating $path%n")
            );

            try {
                Toml::parseFile($path);
                WP_CLI::success("File '$path' is valid.");
            } catch (ParseException $parseException) {
                WP_CLI::error_multi_line([
                    $parseException->getMessage(),
                ]);

                WP_CLI::warning("File '$path' will be ignored.");
            }

            // Print a empty line for better UX.
            WP_CLI::line('');
        }
    }
}
