<?php
declare(strict_types=1);

namespace Itineris\Preflight\CLI\Commands;

use WP_CLI;
use WP_CLI_Command;
use Yosymfony\Toml\Exception\ParseException;
use Yosymfony\Toml\Toml;
use function WP_CLI\Utils\launch_editor_for_input;
use function WP_CLI\Utils\normalize_path;

/**
 * Edits and reads the preflight.toml file.
 */
class ConfigCommand extends WP_CLI_Command
{
    /**
     * Gets the expected path to preflight.toml file.
     *
     * ## EXAMPLES
     *
     *     # Get expected preflight.toml file path
     *     $ wp preflight config path
     *     /home/person/htdocs/project/preflight.toml
     */
    public function path(): void
    {
        WP_CLI::line($this->getPath());
    }

    /**
     * Gets the expected path to the preflight.toml.
     *
     * @return string Expected path to preflight.toml file
     */
    private function getPath(): string
    {
        if (! defined('ABSPATH')) {
            WP_CLI::error("Constant 'ABSPATH' not defined. Did WordPress loaded? Aborted!");
        }

        return normalize_path(ABSPATH . 'preflight.toml');
    }

    /**
     * Prints the content of the preflight.toml file.
     *
     * ## EXAMPLES
     *
     *     # Print the content of the preflight.toml file
     *     $ wp preflight config cat
     */
    public function cat(): void
    {
        $path = $this->getPath();
        if (! file_exists($path)) {
            WP_CLI::error("File '$path' does not exist.");
        }

        $contents = file_get_contents($path); // phpcs:ignore WordPress.WP.AlternativeFunctions

        $contentsWithoutLineBreaks = str_replace(["\r", "\n"], '', $contents);
        if (empty($contentsWithoutLineBreaks)) {
            WP_CLI::warning("File '$path' is empty.");

            return;
        }

        WP_CLI::line($contents);
    }

    /**
     * Launches system editor to edit the preflight.toml file.
     *
     * ## EXAMPLES
     *
     *     # Launch system editor to edit preflight.toml file
     *     $ wp preflight config edit
     *
     *     # Edit preflight.toml file in a specific editor
     *     $ EDITOR=vim wp preflight config edit
     */
    public function edit(): void
    {
        $path = $this->getPath();
        $contents = file_get_contents($path); // phpcs:ignore WordPress.WP.AlternativeFunctions

        $result = launch_editor_for_input($contents, 'preflight.toml', 'toml');

        if (false === $result) {
            WP_CLI::warning("No changes made to '$path'. Aborted!");
        } else {
            file_put_contents($path, $result); // phpcs:ignore WordPress.WP.AlternativeFunctions
        }
    }

    /**
     * Validates the TOML syntax of the preflight.toml file.
     *
     * ## EXAMPLES
     *
     *     # Validate the TOML syntax of the preflight.toml file
     *     $ wp preflight config validate
     *     Success: File '/app/public/preflight.toml' is valid.
     */
    public function validate(): void
    {
        $path = $this->getPath();

        try {
            Toml::parseFile($path);
        } catch (ParseException $parseException) {
            WP_CLI::error($parseException->getMessage());
        }

        WP_CLI::success("File '$path' is valid.");
    }
}
