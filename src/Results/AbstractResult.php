<?php
declare(strict_types=1);

namespace Itineris\Preflight\Results;

use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultInterface;

abstract class AbstractResult implements ResultInterface
{
    /**
     * The checker instance.
     *
     * @var CheckerInterface
     */
    protected $checker;

    /**
     * AbstractResult constructor.
     *
     * @param CheckerInterface $checker The checker instance.
     */
    public function __construct(CheckerInterface $checker)
    {
        $this->checker = $checker;
    }

    /**
     * Returns the checker id.
     *
     * @return string
     */
    public function getCheckerId(): string
    {
        return $this->getChecker()->getId();
    }

    /**
     * Returns the checker instance.
     *
     * @return CheckerInterface
     */
    protected function getChecker(): CheckerInterface
    {
        return $this->checker;
    }
}
