<?php
declare(strict_types=1);

namespace Itineris\Preflight;

use Itineris\Preflight\Results\Disabled;
use Itineris\Preflight\Results\Error;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;

class ResultFactory
{
    /**
     * Make a success instance with optional message.
     *
     * @param CheckerInterface     $checker  The checker instance.
     * @param null|string|string[] $messages Optional. Result message.
     *
     * @return Success
     */
    public static function makeSuccess(CheckerInterface $checker, $messages = null): Success
    {
        return new Success(
            $checker,
            ...self::castIntoArray($messages)
        );
    }

    /**
     * Cast messages into string array.
     *
     * @param null|string|string[] $messages Result message.
     *
     * @return string[]
     */
    private static function castIntoArray($messages): array
    {
        return (array) $messages ?? [];
    }

    /**
     * Make a failure instance with optional message.
     *
     * @param CheckerInterface     $checker  The checker instance.
     * @param null|string|string[] $messages Optional. Result message.
     *
     * @return Failure
     */
    public static function makeFailure(CheckerInterface $checker, $messages = null): Failure
    {
        return new Failure(
            $checker,
            ...self::castIntoArray($messages)
        );
    }

    /**
     * Make a failure instance with optional message.
     *
     * @param CheckerInterface     $checker  The checker instance.
     * @param null|string|string[] $messages Optional. Result message.
     *
     * @return Error
     */
    public static function makeError(CheckerInterface $checker, $messages = null): Error
    {
        return new Error(
            $checker,
            ...self::castIntoArray($messages)
        );
    }

    /**
     * Make a disable instance with optional message.
     *
     * @param CheckerInterface     $checker  The checker instance.
     * @param null|string|string[] $messages Optional. Result message.
     *
     * @return Disabled
     */
    public static function makeDisabled(CheckerInterface $checker, $messages = null): Disabled
    {
        return new Disabled(
            $checker,
            ...self::castIntoArray($messages)
        );
    }
}
