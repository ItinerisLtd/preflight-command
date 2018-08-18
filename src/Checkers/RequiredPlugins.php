<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Checkers\Traits\CompiledIncludesAwareTrait;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Error;
use WP_CLI;

class RequiredPlugins extends AbstractChecker
{
    use CompiledIncludesAwareTrait;

    public const ID = 'required-plugins';
    public const DESCRIPTION = 'Ensure required plugins are installed.';
    public const FAILURE_MESSAGE = 'Required plugins not found:';
    public const DEFAULT_INCLUDES = [];

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
        $installedPlugins = WP_CLI::runcommand(
            'plugin list --fields=name --format=json',
            [
                'return' => true,
                'parse' => 'json',
                'launch' => true,
                'exit_error' => false,
            ]
        );

        $installedPlugins = array_map(function (array $plugin): string {
            return $plugin['name'];
        }, $installedPlugins);

        $missingPlugins = array_diff(
            $config->compileIncludes(static::DEFAULT_INCLUDES),
            $installedPlugins
        );

        return (empty($missingPlugins))
            ? ResultFactory::makeSuccess($this)
            : ResultFactory::makeFailure(
                $this,
                array_merge([self::FAILURE_MESSAGE], $missingPlugins)
            );
    }

    /**
     * {@inheritdoc}
     *
     * @param Config $config The config instance.
     *
     * @return Error|null
     */
    protected function maybeInvalidConfig(Config $config): ?Error
    {
        return $this->errorIfCompiledIncludesIsEmpty($config, static::DEFAULT_INCLUDES);
    }
}
