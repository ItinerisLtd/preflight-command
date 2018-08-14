<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Config;
use Itineris\Preflight\Results\Error;

trait CompiledBlacklistAwareTrait
{
    /**
     * Returns error if compiled blacklist is empty.
     *
     * @param Config $config The config instance.
     *
     * @return Error|null
     */
    protected function errorIfCompiledBlacklistIsEmpty(Config $config): ?Error
    {
        $blacklist = $config->compileBlacklist(self::DEFAULT_BLACKLIST);

        return empty($blacklist)
            ? $this->makeError('Blacklist is empty.')
            : null;
    }

    abstract function makeError(?string $message = null): Error;
}
