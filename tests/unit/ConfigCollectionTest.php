<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test;

use Codeception\Test\Unit;
use Itineris\Preflight\Config;
use Itineris\Preflight\ConfigCollection;
use Mockery;
use WP_Mock;

class ConfigCollectionTest extends Unit
{
    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testGetNotExistConfig()
    {
        $collection = new ConfigCollection([]);

        $expected = Mockery::mock(Config::class);

        WP_Mock::userFunction('Itineris\Preflight\apply_filters')
               ->with(
                   ConfigCollection::HOOK,
                   Mockery::type(Config::class),
                   [],
                   'not-exist'
               )
               ->andReturn($expected)
               ->once();

        $actual = $collection->getConfig('not-exist');

        $this->assertSame($expected, $actual);
    }

    public function testGetConfig()
    {
        $definitions = [
            'my-checker' => [
                'enabled' => false,
                'meaning-of-life' => 42,
            ],
        ];

        $expected = Mockery::mock(Config::class);

        WP_Mock::userFunction('Itineris\Preflight\apply_filters')
               ->with(
                   ConfigCollection::HOOK,
                   Mockery::type(Config::class),
                   $definitions['my-checker'],
                   'my-checker'
               )
               ->andReturn($expected)
               ->once();

        $collection = new ConfigCollection($definitions);

        $actual = $collection->getConfig('my-checker');

        $this->assertSame($expected, $actual);
    }

    public function testGetConfigAlwaysReturnTheSameInstance()
    {
        $definitions = [
            'my-checker' => [
                'enabled' => false,
                'meaning-of-life' => 42,
            ],
        ];

        $expected = Mockery::mock(Config::class);

        WP_Mock::userFunction('Itineris\Preflight\apply_filters')
               ->with(
                   ConfigCollection::HOOK,
                   Mockery::type(Config::class),
                   $definitions['my-checker'],
                   'my-checker'
               )
               ->andReturn($expected)
               ->once();

        $collection = new ConfigCollection($definitions);

        $actual1 = $collection->getConfig('my-checker');
        $actual2 = $collection->getConfig('my-checker');

        $this->assertSame($expected, $actual1);
        $this->assertSame($actual1, $actual2);
    }
}
