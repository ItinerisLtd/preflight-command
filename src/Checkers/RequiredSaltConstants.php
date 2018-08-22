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

    /**
     * {@inheritdoc}
     *
     * @param Config $config The config instance.
     *
     * @return ResultInterface
     */
    protected function run(Config $config): ResultInterface
    {
        $includes = $config->compileIncludes();

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
        return $this->errorIfCompiledIncludesIsEmpty($config);
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
