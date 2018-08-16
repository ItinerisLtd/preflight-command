<?php
declare(strict_types=1);

namespace Itineris\Preflight\Validators;

use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;

class HttpsUrls
{
    public const DEFAULT_FAILURE_MESSAGE = 'URLs are not HTTPS:';
    public const MAKE_HOOK = 'preflight_https_urls_validator_make';

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
     * Make a HttpsUrls instance.
     *
     * Apply the make filter to allow swapping this instance.
     *
     * @param CheckerInterface $checker        The checker instance.
     * @param null|string      $failureMessage Optional. The first line of teh failure message.
     *
     * @return HttpsUrls
     */
    public function make(CheckerInterface $checker, ?string $failureMessage = null): self
    {
        return apply_filters(
            static::MAKE_HOOK,
            new self($checker, $failureMessage),
            $checker,
            $failureMessage
        );
    }

    /**
     * Validates URLs are HTTPS.
     *
     * @param string|string[] ...$urls Urls to be checked.
     *
     * @return Success|Failure
     */
    public function validate(string ...$urls): ResultInterface
    {
        $httpUrls = array_filter($urls, function (string $url): bool {
            return 'https' !== wp_parse_url($url, PHP_URL_SCHEME);
        });

        if (! empty($httpUrls)) {
            return ResultFactory::makeFailure(
                $this->checker,
                array_merge([$this->failureMessage], $httpUrls)
            );
        }

        return ResultFactory::makeSuccess($this->checker);
    }
}
