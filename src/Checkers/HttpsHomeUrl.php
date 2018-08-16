<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Config;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Validators\HttpsUrls;

class HttpsHomeUrl extends AbstractChecker
{
    public const ID = 'https-home-url';
    public const DESCRIPTION = 'Ensure home URL is secure (HTTPS).';
    public const FAILURE_MESSAGE = 'Insecure home URL (non-HTTPS)';

    /**
     * {@inheritdoc}
     *
     * @param Config $config The config instance.
     *
     * @return ResultInterface
     */
    public function run(Config $config): ResultInterface
    {
        $validator = HttpsUrls::make($this, static::FAILURE_MESSAGE);

        return $validator->validate(
            home_url()
        );
    }
}
