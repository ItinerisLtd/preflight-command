<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;

class PrettyPermalinks extends AbstractChecker
{
    public const ID = 'pretty-permalinks';
    public const DESCRIPTION = 'Ensure pretty permalinks is enabled.';

    /**
     * {@inheritdoc}
     *
     * @param Config $config The config instance.
     *
     * @see https://codex.wordpress.org/Using_Permalinks#Check_for_permalink_structure
     *
     * @return ResultInterface
     */
    public function run(Config $config): ResultInterface
    {
        return get_option('permalink_structure')
            ? ResultFactory::makeSuccess($this)
            : ResultFactory::makeFailure($this, 'Permalink structure not defined');
    }
}
