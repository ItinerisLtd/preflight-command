<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Checkers\Traits\CompiledIncludesAwareTrait;
use Itineris\Preflight\Checkers\Traits\ValidatorAwareTrait;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Error;
use Itineris\Preflight\Validators\RequiredConstants;

class RequiredSaltConstants extends AbstractChecker
{
    use ValidatorAwareTrait;
    use CompiledIncludesAwareTrait;

    public const ID = 'required-salt-constants';
    public const DESCRIPTION = 'Ensure required salt constants are defined.';
    public const DEFAULT_INCLUDES = [
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
        $includes = $config->compileIncludes(static::DEFAULT_INCLUDES);

        return $this->validator->validate(...$includes);
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

    /**
     * Returns a default validator instance.
     *
     * Used by the constructor.
     *
     * @return RequiredConstants
     */
    protected function makeDefaultValidator(): RequiredConstants
    {
        return new RequiredConstants($this, 'Required salt constants are not defined:');
    }
}
