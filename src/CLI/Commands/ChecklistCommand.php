<?php
declare(strict_types=1);

namespace Itineris\Preflight\CLI\Commands;

use Itineris\Preflight\CheckerCollectionFactory;
use Itineris\Preflight\CLI\CheckerCollectionPresenter;
use WP_CLI_Command;

class ChecklistCommand extends WP_CLI_Command
{
    /**
     * Lists all registered checkers (without running them).
     *
     * ## OPTIONS
     *
     * [--fields=<fields>]
     * : Limit the output to specific checker fields.
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
     *   - count
     *   - ids
     * ---
     *
     * ## AVAILABLE FIELDS
     *
     * These fields will be displayed by default for each checker:
     *
     * * id
     * * description
     * * link
     *
     * ## EXAMPLES
     *
     *     # List all checkers
     *     $ wp preflight checklist
     *
     *     # List all checkers in given format
     *     $ wp preflight checklist --format=yaml
     *
     *     # List all checkers with only given fields in given format
     *     $ wp preflight checklist --fields=id,description --format=json
     */
    public function __invoke($_args, $assocArgs): void
    {
        CheckerCollectionPresenter::display(
            $assocArgs,
            CheckerCollectionFactory::make()
        );
    }
}
