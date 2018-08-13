<?php
declare(strict_types=1);

namespace Itineris\Preflight;

interface CheckerInterface
{
    /**
     * Returns the id of this checker which unique per instance.
     * Use lowercase alphabets and hyphens only.
     *
     * @return string
     */
    public function getId(): string;
}
