<?php
declare(strict_types=1);

namespace Itineris\Preflight\Results;

use Itineris\Preflight\ResultInterface;

final class Failure extends AbstractResult
{
    /**
     * Returns the status.
     *
     * @return ResultInterface::STATUS_FAILURE;
     */
    public function getStatus(): string
    {
        return ResultInterface::STATUS_FAILURE;
    }
}
