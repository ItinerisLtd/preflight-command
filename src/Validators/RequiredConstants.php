<?php
declare(strict_types=1);

namespace Itineris\Preflight\Validators;

use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;

class RequiredConstants extends AbstractValidator
{
    public const DEFAULT_FAILURE_MESSAGE = 'Required constants are not defined:';

    /**
     * Validates constants are defined.
     *
     * @param string|string[] ...$constantNames Constants to be checked.
     *
     * @return Success|Failure
     */
    public function validate(string ...$constantNames): ResultInterface
    {
        $notDefined = array_filter(
            $constantNames,
            function (string $key): bool {
                // phpcs:ignore WordPressVIPMinimum.Constants.ConstantString.NotCheckingConstantName
                return ! defined($key);
            }
        );

        return $this->report(...$notDefined);
    }
}
