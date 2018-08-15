<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;

class RobotsTxt extends AbstractChecker
{
    public const ID = 'robots-txt';
    public const DESCRIPTION = 'Ensure robots.txt is 200 OK.';

    /**
     * {@inheritdoc}
     *
     * @param Config $config The config instance.
     *
     * @return ResultInterface
     */
    public function run(Config $config): ResultInterface
    {
        $url = home_url('/robots.txt');
        $responseCode = wp_remote_retrieve_response_code(
            wp_remote_get($url)
        );

        if (! is_int($responseCode)) {
            return ResultFactory::makeFailure($this, 'Unable to reach ' . $url);
        }

        return (200 === $responseCode)
            ? ResultFactory::makeSuccess($this)
            : ResultFactory::makeFailure($this, $url . ' returns ' . $responseCode);
    }
}
