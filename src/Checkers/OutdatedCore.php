<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;
use WP_CLI;

class OutdatedCore extends AbstractChecker
{
    public const ID = 'outdated-core';
    public const DESCRIPTION = 'Ensure WordPress core is up-to-date.';
    public const FAILURE_MESSAGE = 'WP core update available:';

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
        $newerCores = WP_CLI::runcommand(
            'core check-update --fields=version,update_type --format=json',
            [
                'return' => true,
                'parse' => 'json',
                'launch' => true,
                'exit_error' => false,
            ]
        );

        $messages = [];
        if (is_array($newerCores)) {
            $messages = array_map(function (array $core): string {
                return "${core['version']} (${core['update_type']})";
            }, $newerCores);
        }

        return (empty($messages))
            ? ResultFactory::makeSuccess($this)
            : ResultFactory::makeFailure(
                $this,
                array_merge([self::FAILURE_MESSAGE], $messages)
            );
    }
}
