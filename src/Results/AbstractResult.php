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
     * @param CheckerInterface $checker     The checker instance.
     * @param string|string[]  ...$messages The result messages.
     */
    public function __construct(CheckerInterface $checker, string ...$messages)
    {
        $this->checker = $checker;
        $this->messages = $messages;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getStatus(): string
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
     * {@inheritdoc}
     *
     * @return string[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * {@inheritdoc}
     *
     * @return CheckerInterface
     */
    public function getChecker(): CheckerInterface
    {
        return $this->checker;
    }
}
