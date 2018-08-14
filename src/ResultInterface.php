<?php
declare(strict_types=1);

namespace Itineris\Preflight;

interface ResultInterface
{
    public const STATUS_SUCCESS = 'Succeed';
    public const STATUS_FAILURE = 'Failed';
    public const STATUS_SKIP = 'Skipped';

    /**
     * Returns the checker id.
     *
     * @return string
     */
    public function getCheckerId(): string;

    /**
     * Returns the status.
     *
     * @return string One of ResultInterface::STATUS_*
     */
    public function getStatus(): string;

    /**
     * Returns the result message.
     *
     * @return string
     */
    public function getMessage(): string;
}
