<?php
declare(strict_types=1);

namespace Itineris\Preflight;

class CheckerCollectionFactory
{
    public const REGISTER_HOOK = 'preflight_checker_collection_register';
    public const BOOT_HOOK = 'preflight_checker_collection_boot';

    /**
     * Instantiate a CheckerCollection instance.
     *
     * Run the register hook to allow built-in and third-party checkers to be registered.
     * Run the boot hook to allow messaging registered checkers.
     *
     * @return CheckerCollection
     */
    public static function make(): CheckerCollection
    {
        $checkerCollection = new CheckerCollection();

        do_action(self::REGISTER_HOOK, $checkerCollection);
        do_action(self::BOOT_HOOK, $checkerCollection);

        return $checkerCollection;
    }
}
