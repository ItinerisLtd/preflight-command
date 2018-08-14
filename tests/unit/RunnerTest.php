<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test;

use Codeception\Test\Unit;
use Itineris\Preflight\CheckerCollection;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\Config;
use Itineris\Preflight\ConfigCollection;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Runner;
use Mockery;

class RunnerTest extends Unit
{
    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    /**
     * TODO: Is all these mocking really necessary?
     */
    public function testCheck()
    {
        $configCollection = Mockery::mock(ConfigCollection::class);
        $configCollection->expects('getConfig')
                         ->with(Mockery::type('string'))
                         ->twice()
                         ->andReturn(new Config([]));

        $result1 = Mockery::mock(ResultInterface::class);
        $result2 = Mockery::mock(ResultInterface::class);

        $checker1 = Mockery::mock(CheckerInterface::class);
        $checker1->expects('check')
                 ->with(Mockery::type(Config::class))
                 ->andReturn($result1);
        $checker2 = Mockery::mock(CheckerInterface::class);
        $checker2->expects('check')
                 ->with(Mockery::type(Config::class))
                 ->andReturn($result2);

        $checkerCollection = Mockery::mock(CheckerCollection::class);
        $checkerCollection->expects('all')
                          ->andReturn([
                              'my-checker-1' => $checker1,
                              'my-checker-2' => $checker2,
                          ]);

        $resultCollection = Runner::check($configCollection, $checkerCollection);

        $expected = [
            $result1,
            $result2,
        ];
        $this->assertAttributeSame($expected, 'results', $resultCollection);
    }
}
