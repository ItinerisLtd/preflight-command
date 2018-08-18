<?php
declare(strict_types=1);

namespace Itineris\Preflight\Validators;

use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;

class SecureUrls extends AbstractValidator
{
    public const DEFAULT_FAILURE_MESSAGE = 'URLs are insecure (non-HTTPS):';

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
