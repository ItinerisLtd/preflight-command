<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test;

use Codeception\Test\Unit;
use Itineris\Preflight\CheckerCollection;
use Itineris\Preflight\CheckerInterface;
use Mockery;

class CheckerCollectionTest extends Unit
{
    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testFluentSet()
    {
        $collection = new CheckerCollection();

        $checker = Mockery::mock(CheckerInterface::class);
        $checker->shouldReceive('getId')->andReturn('my-checker');

        $actual = $collection->set($checker);

        $this->assertSame($collection, $actual);
    }

    public function testGet()
    {
        $collection = new CheckerCollection();

        $checker1 = Mockery::mock(CheckerInterface::class);
        $checker1->shouldReceive('getId')->andReturn('my-checker-1');
        $checker2 = Mockery::mock(CheckerInterface::class);
        $checker2->shouldReceive('getId')->andReturn('my-checker-2');

        $collection->set($checker1)
                   ->set($checker2);

        $actual1 = $collection->get('my-checker-1');
        $actual2 = $collection->get('my-checker-2');

        $this->assertSame($checker1, $actual1);
        $this->assertSame($checker2, $actual2);
    }

    public function testAll()
    {
        $collection = new CheckerCollection();

        $checker1 = Mockery::mock(CheckerInterface::class);
        $checker1->shouldReceive('getId')->andReturn('my-checker-1');
        $checker2 = Mockery::mock(CheckerInterface::class);
        $checker2->shouldReceive('getId')->andReturn('my-checker-2');

        $collection->set($checker1)
                   ->set($checker2);

        $actual = $collection->all();

        $expected = [
            'my-checker-1' => $checker1,
            'my-checker-2' => $checker2,
        ];

        $this->assertSame($expected, $actual);
    }
}
