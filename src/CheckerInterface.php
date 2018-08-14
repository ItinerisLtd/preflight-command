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

    /**
     * Run the check and return a result.
     * TODO: Accept config object/array.
     *
     * @return ResultInterface
     */
    public function check(): ResultInterface;

    /**
     * Converts the checker into a plain PHP array
     *
     * @return array
     */
    public function toArray(): array;
}
