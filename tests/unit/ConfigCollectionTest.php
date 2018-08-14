<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test;

use Codeception\Test\Unit;
use Itineris\Preflight\Config;
use Itineris\Preflight\ConfigCollection;

class ConfigCollectionTest extends Unit
{
    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testGetNotExistConfig()
    {
        $collection = new ConfigCollection([]);

        $actual = $collection->getConfig('not-exist');

        $expected = new Config([]);
        $this->assertEquals($expected, $actual);
    }

    public function testGetConfig()
    {
        $definitions = [
            'my-checker' => [
                'enabled' => false,
                'meaning-of-life' => 42,
            ],
        ];

        $collection = new ConfigCollection($definitions);

        $actual = $collection->getConfig('my-checker');

        $expected = new Config($definitions['my-checker']);
        $this->assertEquals($expected, $actual);
    }

    public function testGetConfigAlwaysReturnTheSameInstance()
    {
        $definitions = [
            'my-checker' => [
                'enabled' => false,
                'meaning-of-life' => 42,
            ],
        ];

        $collection = new ConfigCollection($definitions);

        $actual1 = $collection->getConfig('my-checker');
        $actual2 = $collection->getConfig('my-checker');

        $expected = new Config($definitions['my-checker']);
        $this->assertSame($actual1, $actual2);
    }
}
