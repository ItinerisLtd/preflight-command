<?php
declare(strict_types=1);

namespace Itineris\Preflight;

use Itineris\Preflight\Checkers\AllowIndexing;
use Itineris\Preflight\Checkers\BlacklistedUserEmails;
use Itineris\Preflight\Checkers\BlacklistedUsernames;
use Itineris\Preflight\Checkers\HttpsHomeUrl;
use Itineris\Preflight\Checkers\HttpsSiteUrl;
use Itineris\Preflight\Checkers\InactivePlugins;
use Itineris\Preflight\Checkers\OutdatedCore;
use Itineris\Preflight\Checkers\OutdatedPackages;
use Itineris\Preflight\Checkers\OutdatedPlugins;
use Itineris\Preflight\Checkers\PrettyPermalinks;
use Itineris\Preflight\Checkers\ProductionHomeUrl;
use Itineris\Preflight\Checkers\ProductionSiteUrl;
use Itineris\Preflight\Checkers\RequiredPlugins;
use Itineris\Preflight\Checkers\RequiredSaltConstants;
use Itineris\Preflight\Checkers\RobotsTxt;
use Itineris\Preflight\Checkers\Sitemap;
use Itineris\Preflight\Checkers\UniqueSaltConstants;
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
        AllowIndexing::class,
        BlacklistedUserEmails::class,
        BlacklistedUsernames::class,
        HttpsHomeUrl::class,
        HttpsSiteUrl::class,
        InactivePlugins::class,
        OutdatedCore::class,
        OutdatedPackages::class,
        OutdatedPlugins::class,
        PrettyPermalinks::class,
        ProductionHomeUrl::class,
        ProductionSiteUrl::class,
        RequiredPlugins::class,
        RequiredSaltConstants::class,
        RobotsTxt::class,
        Sitemap::class,
        UniqueSaltConstants::class,
    ];

    /**
     * Begin package execution.
     */
    public static function run(): void
    {
        foreach (self::COMMANDS as $name => $callable) {
            WP_CLI::add_command($name, $callable);
        }

        foreach (self::CHECKERS as $checker) {
            WP_CLI::add_wp_hook(CheckerCollectionFactory::REGISTER_HOOK, [$checker, 'register']);
        }
    }
}
