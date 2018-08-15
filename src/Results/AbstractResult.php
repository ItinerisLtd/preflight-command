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
     * The result messages.
     *
     * @var string[]
     */
    protected $messages;

    /**
     * AbstractResult constructor.
     *
     * @param CheckerInterface $checker  The checker instance.
     * @param string[]         $messages The result messages.
     */
    public function __construct(CheckerInterface $checker, array $messages)
    {
        $this->checker = $checker;
        $this->messages = $messages;
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
                'messages' => $this->getMessages(),
            ]
        );
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

    /**
     * Returns the result message.
     *
     * @return string[]
     */
    protected function getMessages(): array
    {
        return $this->messages;
    }
}
