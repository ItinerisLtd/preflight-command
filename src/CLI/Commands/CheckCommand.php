<?php
declare(strict_types=1);

namespace Itineris\Preflight\CLI\Commands;

use Itineris\Preflight\CheckerCollectionFactory;
use Itineris\Preflight\CLI\ConfigPath;
use Itineris\Preflight\CLI\ResultCollectionPresenter;
use Itineris\Preflight\ConfigCollectionFactory;
use Itineris\Preflight\Runner;
use WP_CLI_Command;

class CheckCommand extends WP_CLI_Command
{
    /**
     * Run the checklist.
     *
     * ## OPTIONS
     *
     * [--fields=<fields>]
     * : Limit the output to specific result fields.
     *
     * [--format=<format>]
     * : Render output in a particular format.
     * ---
     * default: table
     * options:
     *   - table
     *   - json
     *   - csv
     *   - yaml
     * ---
     *
     * ## AVAILABLE FIELDS
     *
     * These fields will be displayed by default for each check:
     *
     * * id
     * * status
     *
     * These fields are available upon request:
     *
     * * message
     * * description
     * * link
     *
     * ## EXAMPLES
     *
     *     # List all results
     *     $ wp preflight check
     *
     *     # List all results in given format
     *     $ wp preflight check --format=json
     *
     *     # List all results with specific fields
     *     $ wp preflight check --fields=id,status,message
     *
     *     # List all results with all available fields in given format
     *     $ wp preflight check --fields=id,link,description,status,message --format=yaml
     */
    public function __invoke($_args, $assocArgs): void
    {
        $configCollection = ConfigCollectionFactory::makeFromFile(
            ConfigPath::get()
        );
        $checkerCollection = CheckerCollectionFactory::make();

        $resultCollection = Runner::check($configCollection, $checkerCollection);

        ResultCollectionPresenter::display($assocArgs, $resultCollection);
    }
}
