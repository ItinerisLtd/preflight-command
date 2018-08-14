<?php
declare(strict_types=1);

// TODO: CommandNamespace?
use Itineris\Preflight\CLI\Commands\ConfigCommand;

if (! class_exists('WP_CLI')) {
    return;
}

WP_CLI::add_command('preflight config', ConfigCommand::class);
