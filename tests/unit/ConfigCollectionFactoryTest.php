<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test;

use Codeception\Test\Unit;
use Itineris\Preflight\ConfigCollection;
use Itineris\Preflight\ConfigCollectionFactory;

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

    public function testEmptyToml()
    {
        $actual = ConfigCollectionFactory::makeFromFile(codecept_data_dir('empty.toml'));

        $expected = new ConfigCollection([]);

        $this->assertEquals($expected, $actual);
    }

    public function testCommentToml()
    {
        $actual = ConfigCollectionFactory::makeFromFile(codecept_data_dir('comment.toml'));

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
