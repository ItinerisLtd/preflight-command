<?php
declare(strict_types=1);

namespace Itineris\Preflight;

interface ResultInterface
{
    /**
     * Returns the checker which yields this result instance.
     *
     * Note: One checker might yields multiple result instances.
     *
     * @return CheckerInterface
     */
    public function getChecker(): CheckerInterface;

    /**
     * Returns the status.
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Returns the result messages.
     *
     * One array item stands for one line of message.
     *
     * @return string[]
     */
    public function getMessages(): array;
}
