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
     * @param Config $config The config instance.
     *
     * @return Error|null
     */
    protected function errorIfCompiledIncludesIsEmpty(Config $config): ?Error
    {
        $includes = $config->compileIncludes();

        return empty($includes)
            ? ResultFactory::makeError($this, 'Includes is empty.')
            : null;
    }
}
