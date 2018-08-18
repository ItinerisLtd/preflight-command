<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;
use WP_CLI;

class LatestPlugins extends AbstractChecker
{
    public const ID = 'updated-plugins';
    public const DESCRIPTION = 'Ensure all plugins are up-to-date.';
    public const FAILURE_MESSAGE = 'Plugin updates available:';

    /**
     * Run the check and return a result.
     *
     * Assume the checker is enabled and its config make sense.
     *
     * @param Config $config The config instance.
     *
     * @return ResultInterface
     */
    protected function run(Config $config): ResultInterface
    {
        $outdatedPlugins = WP_CLI::runcommand(
            'plugin list --update=available --fields=name,version,update_version --format=json',
            [
                'return' => true,
                'parse' => 'json',
                'launch' => true,
                'exit_error' => false,
            ]
        );

        $excludes = $config->compileExcludes([]);
        $outdatedPlugins = array_filter($outdatedPlugins, function (array $plugin) use ($excludes): bool {
            return ! in_array($plugin['name'], $excludes, true);
        });

        $messages = array_map(function (array $plugin): string {
            return "${plugin['name']} (${plugin['version']} => ${plugin['update_version']})";
        }, $outdatedPlugins);

        return (empty($messages))
            ? ResultFactory::makeSuccess($this)
            : ResultFactory::makeFailure(
                $this,
                array_merge([self::FAILURE_MESSAGE], $messages)
            );
    }
}
