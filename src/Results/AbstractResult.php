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
     * The result message.
     *
     * @var string
     */
    protected $message;

    /**
     * AbstractResult constructor.
     *
     * @param CheckerInterface $checker The checker instance.
     * @param null|string      $message Optional. The result message.
     */
    public function __construct(CheckerInterface $checker, ?string $message = null)
    {
        $this->checker = $checker;
        $this->message = $message ?? '';
    }

    /**
     * Returns the result message.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
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
