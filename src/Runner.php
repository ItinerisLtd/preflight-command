<?php
declare(strict_types=1);

namespace Itineris\Preflight;

class Runner
{
    /**
     * Run all the checkers according to their configs.
     *
     * @param ConfigCollection  $configCollection  The config collection instance.
     * @param CheckerCollection $checkerCollection The checker collection instance.
     *
     * @return ResultCollection
     */
    public static function check(
        ConfigCollection $configCollection,
        CheckerCollection $checkerCollection
    ): ResultCollection {
        $resultCollection = new ResultCollection();

        foreach ($checkerCollection->all() as $id => $checker) {
            $resultCollection->add(
                $checker->check(
                    $configCollection->getConfig($id)
                )
            );
        }

        return $resultCollection;
    }
}
