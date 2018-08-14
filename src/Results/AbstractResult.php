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
     * {@inheritdoc}
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_merge(
            $this->checker->toArray(),
            [
                'status' => $this->getStatus(),
                'message' => $this->getMessage(),
            ]
        );
    }

    /**
     * Returns the result message.
     *
     * @return string
     */
    protected function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Returns the status.
     *
     * @return string
     */
    protected function getStatus(): string
    {
        return basename(
            str_replace(
                '\\',
                '/',
                get_class($this)
            )
        );
    }
}
