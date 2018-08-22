<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;
use WP_CLI;

class OutdatedPackages extends AbstractChecker
{
    public const ID = 'outdated-packages';
    public const DESCRIPTION = 'Ensure all WP CLI packages are up-to-date.';

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
        $packages = WP_CLI::runcommand(
            'package list --fields=name,version,update_version --format=json',
            [
                'return' => true,
                'parse' => 'json',
                'launch' => true,
                'exit_error' => false,
            ]
        );

        $outdatedPackages = array_filter($packages, function (array $package): bool {
            return ! empty($package['update_version']);
        });

        $excludes = $config->compileExcludes([]);
        $outdatedPackages = array_filter($outdatedPackages, function (array $package) use ($excludes): bool {
            $isNotExcluded = ! in_array($package['name'], $excludes, true);

            // To exclude dev-master.
            $isNotDev = $package['update_version'] !== $package['version'];

            return $isNotExcluded && $isNotDev;
        });

        $messages = array_map(function (array $package): string {
            return "${package['name']} (${package['version']} => ${package['update_version']})";
        }, $outdatedPackages);

        return (empty($messages))
            ? ResultFactory::makeSuccess($this)
            : ResultFactory::makeFailure(
                $this,
                array_merge(['WP CLI package updates available:'], $messages)
            );
    }
}
