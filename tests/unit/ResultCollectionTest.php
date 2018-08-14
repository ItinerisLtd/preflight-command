<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test;

use Codeception\Test\Unit;
use Itineris\Preflight\ResultCollection;
use Itineris\Preflight\ResultInterface;
use Mockery;

class ResultCollectionTest extends Unit
{
    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testFluentAdd()
    {
        $result = Mockery::mock(ResultInterface::class);

        $collection = new ResultCollection();

        $actual = $collection->add($result);

        $this->assertSame($collection, $actual);
    }

    public function testAddAndAll()
    {
        $result1 = Mockery::mock(ResultInterface::class);
        $result2 = Mockery::mock(ResultInterface::class);

        $collection = new ResultCollection();

        $collection->add($result1);
        $collection->add($result2);

        $actual = $collection->all();

        $expected = [
            $result1,
            $result2,
        ];

        $this->assertSame($expected, $actual);
    }
}
