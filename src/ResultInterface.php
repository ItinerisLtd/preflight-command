<?php
declare(strict_types=1);

namespace Itineris\Preflight;

interface ResultInterface
{
    /**
     * Converts the underlying result into a plain PHP array.
     *
     * @return array
     */
    public function toArray(): array;
}
