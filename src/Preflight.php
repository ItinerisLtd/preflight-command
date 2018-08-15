<?php
declare(strict_types=1);

namespace Itineris\Preflight;

use Itineris\Preflight\Checkers\BadUserLoginOrEmail;
use Itineris\Preflight\Checkers\PrettyPermalinks;
use Itineris\Preflight\Checkers\RobotsTxt;
use Itineris\Preflight\Checkers\Sitemap;
use Itineris\Preflight\CLI\Commands\CheckCommand;
use Itineris\Preflight\CLI\Commands\ChecklistCommand;
use Itineris\Preflight\CLI\Commands\CommandNamespace;
use Itineris\Preflight\CLI\Commands\ConfigCommand;
use WP_CLI;

class Preflight
{
    private const COMMANDS = [
        'preflight' => CommandNamespace::class,
        'preflight check' => CheckCommand::class,
        'preflight checklist' => ChecklistCommand::class,
        'preflight config' => ConfigCommand::class,
    ];

    private const CHECKERS = [
        BadUserLoginOrEmail::class,
        PrettyPermalinks::class,
        RobotsTxt::class,
        Sitemap::class,
    ];

    /**
     * Begin package execution.
     */
    public static function run(): void
    {
        // TODO: CommandNamespace?
        foreach (self::COMMANDS as $name => $callable) {
            WP_CLI::add_command($name, $callable);
        }

        foreach (self::CHECKERS as $checker) {
            WP_CLI::add_wp_hook(CheckerCollectionFactory::REGISTER_HOOK, [$checker, 'register']);
        }
    }
}
