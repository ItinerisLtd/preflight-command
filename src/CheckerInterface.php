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
     * Returns the URL to the checker document web page.
     *
     * @return string
     */
    public function getLink(): string;

    /**
     * Returns the description of the checker.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Run the check and return a result.
     *
     * @param Config $config The config instance.
     *
     * @return ResultInterface
     */
    public function check(Config $config): ResultInterface;
}
