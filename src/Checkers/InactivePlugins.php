<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;
use WP_CLI;

class InactivePlugins extends AbstractChecker
{
    public const ID = 'inactive-plugins';
    public const DESCRIPTION = 'Ensure all plugins are activated.';

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
        $deactivatedPlugins = WP_CLI::runcommand(
            'plugin list --status=inactive --fields=name --format=json',
            [
                'return' => true,
                'parse' => 'json',
                'launch' => true,
                'exit_error' => false,
            ]
        );

        $excludes = $config->compileExcludes([]);
        $deactivatedPlugins = array_filter($deactivatedPlugins, function (array $plugin) use ($excludes): bool {
            return ! in_array($plugin['name'], $excludes, true);
        });

        $messages = array_map(function (array $plugin): string {
            return $plugin['name'];
        }, $deactivatedPlugins);

        return (empty($messages))
            ? ResultFactory::makeSuccess($this)
            : ResultFactory::makeFailure(
                $this,
                array_merge(['Inactive plugins found:'], $messages)
            );
    }
}
