<?php
declare(strict_types=1);

namespace Itineris\Preflight\Validators;

use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;

abstract class AbstractValidator
{
    public const DEFAULT_FAILURE_MESSAGE = self::DEFAULT_FAILURE_MESSAGE;
    public const MAKE_HOOK = self::MAKE_HOOK;

    /**
     * The checker instance.
     *
     * @var CheckerInterface
     */
    protected $checker;

    /**
     * The first line of teh failure message.
     *
     * @var string
     */
    protected $failureMessage;

    /**
     * Make a HttpsUrls instance.
     *
     * Apply the make filter to allow swapping this instance.
     * Main goal is to make validators testable/mock-able.
     *
     * @param CheckerInterface $checker        The checker instance.
     * @param null|string      $failureMessage Optional. The first line of teh failure message.
     *
     * @return self
     */
    public static function make(CheckerInterface $checker, ?string $failureMessage = null): self
    {
        return apply_filters(
            static::MAKE_HOOK,
            new static($checker, $failureMessage),
            $checker,
            $failureMessage
        );
    }

    /**
     * HttpsUrls constructor.
     *
     * @param CheckerInterface $checker        The checker instance.
     * @param null|string      $failureMessage Optional. The first line of teh failure message.
     */
    public function __construct(CheckerInterface $checker, ?string $failureMessage = null)
    {
        $this->checker = $checker;
        // TODO: Use null coalescing assignment operator.
        $this->failureMessage = $failureMessage ?? static::DEFAULT_FAILURE_MESSAGE;
    }

    /**
     * Returns result instance.
     *
     * @param string|string[] ...$messages Failure message. If empty, assume success.
     *
     * @return Failure|Success
     */
    protected function report(string ...$messages): ResultInterface
    {
        if (! empty($messages)) {
            return ResultFactory::makeFailure(
                $this->checker,
                array_merge([$this->failureMessage], $messages)
            );
        }

        return ResultFactory::makeSuccess($this->checker);
    }
}
