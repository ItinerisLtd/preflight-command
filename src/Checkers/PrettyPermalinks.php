<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;

class PrettyPermalinks implements CheckerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return 'pretty-permalinks';
    }

    /**
     * {@inheritdoc}
     *
     * @see https://codex.wordpress.org/Using_Permalinks#Check_for_permalink_structure
     */
    public function check(): ResultInterface
    {
        if (! get_option('permalink_structure')) {
            return new Failure($this);
        }

        return new Success($this);
    }
}
