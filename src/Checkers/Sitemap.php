<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;

class Sitemap extends AbstractChecker
{
    public const ID = 'sitemap';
    public const DESCRIPTION = 'Ensure sitemap is 200 OK.';

    private const DEFAULT_PATH = '/sitemap_index.xml';

    /**
     * {@inheritdoc}
     *
     * @param Config $config The config instance.
     *
     * @return ResultInterface
     */
    protected function run(Config $config): ResultInterface
    {
        $path = $config->getPath() ?: self::DEFAULT_PATH;
        $url = home_url($path);
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
