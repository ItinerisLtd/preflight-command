<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers\Traits;

use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Error;

trait CompiledBlacklistAwareTrait
{
    /**
     * Returns error if compiled blacklist is empty.
     *
     * @param Config $config The config instance.
     *
     * @param array  $defaultIncludes The default blacklist.
     *
     * @return Error|null
     */
    protected function errorIfCompiledBlacklistIsEmpty(Config $config, array $defaultIncludes): ?Error
    {
        $blacklist = $config->compileBlacklist($defaultIncludes);

        return empty($blacklist)
            ? ResultFactory::makeError($this, 'Blacklist is empty.')
            : null;
    }
}
