<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;

class AllowIndexing extends AbstractChecker
{
    public const ID = 'allow-indexing';
    public const DESCRIPTION = 'Ensure site is visible to everyone, including search engines and archivers.';

    /**
     * Run the check and return a result.
     *
     * Assume the checker is enabled and its config make sense.
     *
     * @param Config $config The config instance.
     *
     * @return ResultInterface
     */
    protected function run(Config $config): ResultInterface
    {
        return (1 === (int) get_option('blog_public'))
            ? ResultFactory::makeSuccess($this)
            : ResultFactory::makeFailure(
                $this,
                [
                    'Indexing not allowed:',
                    'Block search engines, but allow normal visitors',
                ]
            );
    }
}
