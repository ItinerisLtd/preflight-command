<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Checkers\Traits\ValidatorAwareTrait;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Validators\SecureUrls;

class SecureSiteUrl extends AbstractChecker
{
    use ValidatorAwareTrait;

    public const ID = 'secure-site-url';
    public const DESCRIPTION = 'Ensure site URL is secure (HTTPS).';

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
            site_url()
        );
    }

    /**
     * Returns a default validator instance.
     *
     * Used by the constructor.
     *
     * @return SecureUrls
     */
    protected function makeDefaultValidator(): SecureUrls
    {
        return new SecureUrls($this, 'Insecure(non-HTTPS) site URL');
    }
}
