<?php
declare(strict_types=1);

namespace Itineris\Preflight\Validators;

use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;

class HttpsUrls extends AbstractValidator
{
    public const DEFAULT_FAILURE_MESSAGE = 'URLs are not HTTPS:';
    public const MAKE_HOOK = 'preflight_https_urls_validator_make';

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

        return $this->report(...$httpUrls);
    }
}
