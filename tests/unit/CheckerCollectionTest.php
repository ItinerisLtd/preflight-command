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
        $checker = Mockery::mock(CheckerInterface::class);
        $checker->shouldReceive('getId')->andReturn('my-checker');

        $collection = new CheckerCollection();

        $actual = $collection->set($checker);

        $this->assertSame($collection, $actual);
    }

    public function testGet()
    {
        $checker1 = Mockery::mock(CheckerInterface::class);
        $checker1->shouldReceive('getId')->andReturn('my-checker-1');
        $checker2 = Mockery::mock(CheckerInterface::class);
        $checker2->shouldReceive('getId')->andReturn('my-checker-2');

        $collection = new CheckerCollection();

        $collection->set($checker1)
                   ->set($checker2);

        $actual1 = $collection->get('my-checker-1');
        $actual2 = $collection->get('my-checker-2');

        $this->assertSame($checker1, $actual1);
        $this->assertSame($checker2, $actual2);
    }

    public function testAll()
    {
        $checker1 = Mockery::mock(CheckerInterface::class);
        $checker1->shouldReceive('getId')->andReturn('my-checker-1');
        $checker2 = Mockery::mock(CheckerInterface::class);
        $checker2->shouldReceive('getId')->andReturn('my-checker-2');

        $collection = new CheckerCollection();

        $collection->set($checker1);
        $collection->set($checker2);

        $actual = $collection->all();

        $expected = [
            'my-checker-1' => $checker1,
            'my-checker-2' => $checker2,
        ];

        $this->assertSame($expected, $actual);
    }

    public function testToArray()
    {
        $definition1 = [
            'aaa' => 'bbb',
        ];
        $checker1 = Mockery::mock(CheckerInterface::class);
        $checker1->shouldReceive('getId')->andReturn('my-checker-1');
        $checker1->shouldReceive('toArray')->andReturn($definition1);
        $definition2 = [
            'yyy' => 'zzz',
        ];
        $checker2 = Mockery::mock(CheckerInterface::class);
        $checker2->shouldReceive('getId')->andReturn('my-checker-2');
        $checker2->shouldReceive('toArray')->andReturn($definition2);

        $collection = new CheckerCollection();

        $collection->set($checker1);
        $collection->set($checker2);

        $actual = $collection->toArray();

        $expected = [
            'my-checker-1' => $definition1,
            'my-checker-2' => $definition2,
        ];

        $this->assertSame($expected, $actual);
    }

    public function testPluckIds()
    {
        $checker1 = Mockery::mock(CheckerInterface::class);
        $checker1->shouldReceive('getId')->andReturn('my-checker-1');
        $checker2 = Mockery::mock(CheckerInterface::class);
        $checker2->shouldReceive('getId')->andReturn('my-checker-2');

        $collection = new CheckerCollection();

        $collection->set($checker1);
        $collection->set($checker2);

        $actual = $collection->pluckIds();

        $expected = [
            'my-checker-1',
            'my-checker-2',
        ];

        $this->assertSame($expected, $actual);
    }
}
