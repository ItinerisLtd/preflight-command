<?php
declare(strict_types=1);

namespace Itineris\Preflight;

use Itineris\Preflight\Checkers\BadUserLoginOrEmail;
use Itineris\Preflight\Checkers\BlacklistedUserEmails;
use Itineris\Preflight\Checkers\BlacklistedUsernames;
use Itineris\Preflight\Checkers\DefinedSaltConstants;
use Itineris\Preflight\Checkers\HttpsHomeUrl;
use Itineris\Preflight\Checkers\HttpsSiteUrl;
use Itineris\Preflight\Checkers\PrettyPermalinks;
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
        BlacklistedUserEmails::class,
        BlacklistedUsernames::class,
        DefinedSaltConstants::class,
        HttpsHomeUrl::class,
        HttpsSiteUrl::class,
        PrettyPermalinks::class,
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
