<?php
declare(strict_types=1);

namespace Itineris\Preflight\Results;

use Itineris\Preflight\ResultInterface;

final class Disabled extends AbstractResult
{
    /**
     * Returns the status.
     *
     * @return ResultInterface::STATUS_SKIP
     */
    protected function getStatusCode(): string
    {
        return ResultInterface::STATUS_CODE_SKIP;
    }
}
