<?php
declare(strict_types=1);

namespace Itineris\Preflight\CLI\Commands;

use Itineris\Preflight\CheckerCollectionFactory;
use WP_CLI\Formatter;
use WP_CLI_Command;

class ChecklistCommand extends WP_CLI_Command
{
    private const AVAILABLE_FIELDS = [
        'id',
        'description',
        'link',
    ];

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
        $formatter = new Formatter($assocArgs, self::AVAILABLE_FIELDS);

        $checkerCollection = CheckerCollectionFactory::make();

        $items = (in_array($formatter->format, ['ids', 'count'], true))
            ? $checkerCollection->pluckIds()
            : $checkerCollection->toArray();

        $formatter->display_items($items);
    }
}
