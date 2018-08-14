<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test;

use Codeception\Test\Unit;
use Itineris\Preflight\CheckerCollection;
use Itineris\Preflight\CheckerCollectionFactory;
use Mockery;
use WP_Mock;

class CheckerCollectionFactoryTest extends Unit
{
    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testRegisterAndBootHooks()
    {
        WP_Mock::userFunction('Itineris\Preflight\do_action')
               ->withArgs([CheckerCollectionFactory::REGISTER_HOOK, Mockery::type(CheckerCollection::class)])
               ->once();
        WP_Mock::userFunction('Itineris\Preflight\do_action')
               ->withArgs([CheckerCollectionFactory::BOOT_HOOK, Mockery::type(CheckerCollection::class)])
               ->once();

        CheckerCollectionFactory::make();
    }
}
