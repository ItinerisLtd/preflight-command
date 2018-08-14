<?php
declare(strict_types=1);

use Itineris\Preflight\Preflight;

if (! class_exists('WP_CLI')) {
    return;
}

Preflight::run();
