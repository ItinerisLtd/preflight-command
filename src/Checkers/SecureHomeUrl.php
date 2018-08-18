<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Checkers\Traits\ValidatorAwareTrait;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Validators\HttpsUrls;

class SecureHomeUrl extends AbstractChecker
{
    use ValidatorAwareTrait;

    public const ID = 'secure-home-url';
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
        return $this->validator->validate(
            home_url()
        );
    }

    /**
     * Returns a default validator instance.
     *
     * Used by the constructor.
     *
     * @return HttpsUrls
     */
    protected function makeDefaultValidator(): HttpsUrls
    {
        return new HttpsUrls($this);
    }
}
