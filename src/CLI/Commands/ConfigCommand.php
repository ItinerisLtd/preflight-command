<?php
declare(strict_types=1);

namespace Itineris\Preflight\CLI\Commands;

use RuntimeException;
use WP_CLI;
use WP_CLI_Command;
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
     *
     * @throws RuntimeException If constant ABSPATH is not defined.
     */
    private function getPath(): string
    {
        if (! defined('ABSPATH')) {
            throw new RuntimeException('Constant ABSPATH not defined. Did WordPress loaded?');
        }

        $path = ABSPATH . 'preflight.toml';

        return normalize_path($path);
    }

    /**
     * Prints the content of the preflight.toml file.
     *
     * ## EXAMPLES
     *
     *     # Print the content of the preflight.toml file
     *     $ wp preflight config cat
     *
     *     # If preflight.toml is empty:
     *     $ wp preflight config cat
     *     Warning: preflight.toml is empty.
     *
     *     # If preflight.toml doesn't exist:
     *     $ wp preflight config cat
     *     preflight.toml not found.
     *     Run '$ wp preflight config path' to check the expected path.
     */
    public function cat(): void
    {
        $path = $this->getPath();
        if (! file_exists($path)) {
            WP_CLI::error_multi_line([
                "preflight.toml doesn't exist.",
                "Run '$ wp preflight config path' to check its expected path.",
            ]);
            WP_CLI::halt(127);
        }

        $contents = file_get_contents($path); // phpcs:ignore WordPress.WP.AlternativeFunctions
        if (empty($contents)) {
            WP_CLI::warning('preflight.toml is empty.');
            WP_CLI::halt(127);
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
    public function edit()
    {
        $path = $this->getPath();
        $contents = file_get_contents($path); // phpcs:ignore WordPress.WP.AlternativeFunctions

        $result = launch_editor_for_input($contents, 'preflight.toml', 'toml');

        if (false === $result) {
            WP_CLI::warning('No changes made to preflight.toml. Aborted!');
        } else {
            file_put_contents($path, $result); // phpcs:ignore WordPress.WP.AlternativeFunctions
        }
    }
}
