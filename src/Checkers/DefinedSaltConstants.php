<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Checkers\Traits\CompiledIncludesAwareTrait;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Error;

class DefinedSaltConstants extends AbstractChecker
{
    use CompiledIncludesAwareTrait;

    public const ID = 'defined-salt-constants';
    public const DESCRIPTION = 'Ensure each salt constant is unique.';
    const DEFAULT_INCLUDES = [
        'AUTH_KEY',
        'SECURE_AUTH_KEY',
        'LOGGED_IN_KEY',
        'NONCE_KEY',
        'AUTH_SALT',
        'SECURE_AUTH_SALT',
        'LOGGED_IN_SALT',
        'NONCE_SALT',
    ];

    /**
     * {@inheritdoc}
     *
     * @param Config $config The config instance.
     *
     * @return ResultInterface
     */
    protected function run(Config $config): ResultInterface
    {
        $notDefined = array_filter(
            $config->compileIncludes(static::DEFAULT_INCLUDES),
            function (string $key): bool {
                // phpcs:ignore WordPressVIPMinimum.Constants.ConstantString.NotCheckingConstantName
                return ! defined($key);
            }
        );

        if (! empty($notDefined)) {
            $messages = array_merge(['Salt constants are not defined:'], $notDefined);

            return ResultFactory::makeFailure($this, $messages);
        }

        return ResultFactory::makeSuccess($this);
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
        return $this->errorIfCompiledIncludesIsEmpty($config, self::DEFAULT_INCLUDES);
    }
}
