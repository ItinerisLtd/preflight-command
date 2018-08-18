<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers\Traits;

use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Error;

trait CompiledIncludesAwareTrait
{
    /**
     * Returns error if compiled includes is empty.
     *
     * @param Config $config          The config instance.
     * @param array  $defaultIncludes The default includes.
     *
     * @return Error|null
     */
    protected function errorIfCompiledIncludesIsEmpty(Config $config, array $defaultIncludes): ?Error
    {
        $includes = $config->compileIncludes($defaultIncludes);

        return empty($includes)
            ? ResultFactory::makeError($this, 'Includes is empty.')
            : null;
    }
}
