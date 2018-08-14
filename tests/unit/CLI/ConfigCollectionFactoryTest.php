<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\CLI;

use Codeception\Test\Unit;
use Itineris\Preflight\CLI\ConfigCollectionFactory;
use Itineris\Preflight\ConfigCollection;

class ConfigCollectionFactoryTest extends Unit
{
    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testFileNotExist()
    {
        $actual = ConfigCollectionFactory::makeFromFile('/file/not/exist.toml');

        $expected = new ConfigCollection([]);

        $this->assertEquals($expected, $actual);
    }

    public function testTomlSyntaxError()
    {
        $actual = ConfigCollectionFactory::makeFromFile(codecept_root_dir('composer.json'));

        $expected = new ConfigCollection([]);

        $this->assertEquals($expected, $actual);
    }

    public function testMakeFromFile()
    {
        $actual = ConfigCollectionFactory::makeFromFile(codecept_data_dir('simple.toml'));

        $expected = [
            'airline' => 'Itineris Air',
            'Aircraft' => 'Hello World 747',
            'destination' => [
                'longitude' => 0,
                'latitude' => 51.476852,
            ],
            'the-pilot' => [
                'name' => 'Tang Rufus',
                'email' => 'tangrufus@gmail.com',
            ],
        ];

        $this->assertAttributeSame($expected, 'definitions', $actual);
    }
}
