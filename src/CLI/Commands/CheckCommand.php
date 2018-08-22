<?php
declare(strict_types=1);

namespace Itineris\Preflight\CLI\Commands;

use Itineris\Preflight\CheckerCollectionFactory;
use Itineris\Preflight\CLI\ConfigPath;
use Itineris\Preflight\CLI\ResultCollectionPresenter;
use Itineris\Preflight\ConfigCollectionFactory;
use Itineris\Preflight\ConfigPaths;
use Itineris\Preflight\Runner;
use WP_CLI_Command;

class CheckCommand extends WP_CLI_Command
{
    /**
     * Run the checklist and list the results.
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
     * * messages
     * * message (implode all messages into one long string)
     * * description
     * * link
     *
     * ## EXAMPLES
     *
     *     # Run the checklist and list all results.
     *     $ wp preflight check
     *
     *     # Run the checklist and list all results in given format
     *     $ wp preflight check --format=json
     *
     *     # Run the checklist and list all results with given fields
     *     $ wp preflight check --fields=id,status,message,description,link
     *
     *     # Run the checklist and list all results with given fields in given format
     *     $ wp preflight check --fields=id,description,link,status,messages --format=yaml
     */
    public function __invoke($_args, $assocArgs): void
    {
        $configCollection = ConfigCollectionFactory::makeFromFiles(
            ...ConfigPaths::all()
        );
        $checkerCollection = CheckerCollectionFactory::make();

        $resultCollection = Runner::check($configCollection, $checkerCollection);

        ResultCollectionPresenter::display($assocArgs, $resultCollection);
    }
}
