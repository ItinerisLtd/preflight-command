<?php
declare(strict_types=1);

namespace Itineris\Preflight;

use Itineris\Preflight\Checkers\BadUserLoginOrEmail;
use Itineris\Preflight\Checkers\PrettyPermalinks;
use Itineris\Preflight\CLI\Commands\ChecklistCommand;
use Itineris\Preflight\CLI\Commands\ConfigCommand;
use WP_CLI;

class Preflight
{
    /**
     * Begin package execution.
     */
    public static function run(): void
    {
        // TODO: CommandNamespace?
        WP_CLI::add_command('preflight checklist', ChecklistCommand::class);
        WP_CLI::add_command('preflight config', ConfigCommand::class);

        WP_CLI::add_wp_hook(CheckerCollectionFactory::REGISTER_HOOK, [BadUserLoginOrEmail::class, 'register']);
        WP_CLI::add_wp_hook(CheckerCollectionFactory::REGISTER_HOOK, [PrettyPermalinks::class, 'register']);
    }
}
