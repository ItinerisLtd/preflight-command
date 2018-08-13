<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\TestInterface;
use Mockery;

class Unit extends \Codeception\Module
{
    public function _after(TestInterface $test)
    {
        Mockery::close();
    }
}
