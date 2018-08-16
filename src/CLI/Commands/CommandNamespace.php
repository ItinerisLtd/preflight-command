<?php
declare(strict_types=1);

namespace Itineris\Preflight\CLI\Commands;

use WP_CLI\Dispatcher\CommandNamespace as BaseCommandNamespace;

/**
 * Check for common mistakes and enforce best practices before take off.
 *
 * ## EXAMPLES
 *
 *     # Run the checklist and list the results
 *     $ wp preflight check
 *
 *     # Lists all registered checkers (without running them)
 *     $ wp preflight checklist
 *
 *     # Edit the preflight.toml file
 *     $ wp preflight config edit
 *
 *     # Validate the TOML syntax of the preflight.toml file
 *     $ wp preflight config validate
 */
class CommandNamespace extends BaseCommandNamespace
{
}
