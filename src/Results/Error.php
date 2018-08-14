<?php
declare(strict_types=1);

namespace Itineris\Preflight\Results;

use Itineris\Preflight\ResultInterface;

final class Error extends AbstractResult
{
    /**
     * Returns the status.
     *
     * @return ResultInterface::STATUS_FAILURE
     */
    protected function getStatusCode(): string
    {
        return ResultInterface::STATUS_CODE_FAILURE;
    }
}
