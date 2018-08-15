<?php
declare(strict_types=1);

namespace Itineris\Preflight;

interface ResultInterface
{
    /**
     * Converts the underlying result into a plain PHP array.
     *
     * TODO: Rethink this interface. Maybe ::getCheckerId(), ::getStatus(), ::getMessages()?
     *
     * @return array
     */
    public function toArray(): array;
}
