<?php
declare(strict_types=1);

namespace Itineris\Preflight\CLI\Commands;

use Itineris\Preflight\CLI\ConfigPath;
use WP_CLI;
use WP_CLI_Command;
use Yosymfony\Toml\Exception\ParseException;
use Yosymfony\Toml\Toml;
use function WP_CLI\Utils\launch_editor_for_input;

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
        WP_CLI::line(
            ConfigPath::get()
        );
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
        $path = ConfigPath::get();
        if (! file_exists($path)) {
            WP_CLI::error("File '$path' does not exist.");
        }
        // phpcs:ignore WordPressVIPMinimum.VIP.FetchingRemoteData.fileGetContentsUknown
        $contents = file_get_contents($path);

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
        $path = ConfigPath::get();
        // phpcs:ignore WordPressVIPMinimum.VIP.FetchingRemoteData.fileGetContentsUknown
        $contents = file_get_contents($path);
        $result = launch_editor_for_input($contents, 'preflight.toml', 'toml');

        if (false === $result) {
            WP_CLI::warning("No changes made to '$path'. Aborted!");
        } else {
            // phpcs:disable WordPress.VIP.FileSystemWritesDisallow
            // phpcs:disable WordPress.WP.AlternativeFunctions.file_system_read_file_put_contents
            file_put_contents($path, $result);
            // phpcs:enable
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
        $path = ConfigPath::get();

        try {
            Toml::parseFile($path);
        } catch (ParseException $parseException) {
            WP_CLI::error($parseException->getMessage());
        }

        WP_CLI::success("File '$path' is valid.");
    }
}
