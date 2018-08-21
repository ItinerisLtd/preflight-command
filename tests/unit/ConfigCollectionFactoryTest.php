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
        $actual = ConfigCollectionFactory::makeFromFiles('/file/not/exist.toml');

        $expected = new ConfigCollection([]);

        $this->assertEquals($expected, $actual);
    }

    public function testTomlSyntaxError()
    {
        $actual = ConfigCollectionFactory::makeFromFiles(codecept_root_dir('composer.json'));

        $expected = new ConfigCollection([]);

        $this->assertEquals($expected, $actual);
    }

    public function testEmptyToml()
    {
        $actual = ConfigCollectionFactory::makeFromFiles(codecept_data_dir('empty.toml'));

        $expected = new ConfigCollection([]);

        $this->assertEquals($expected, $actual);
    }

    public function testCommentToml()
    {
        $actual = ConfigCollectionFactory::makeFromFiles(codecept_data_dir('comment.toml'));

        $expected = new ConfigCollection([]);

        $this->assertEquals($expected, $actual);
    }

    public function testMakeFromFile()
    {
        $actual = ConfigCollectionFactory::makeFromFiles(codecept_data_dir('simple.toml'));

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

    public function testMergeTwoFiles()
    {
        $actual = ConfigCollectionFactory::makeFromFiles(
            codecept_data_dir('base.toml'),
            codecept_data_dir('package.toml')
        );

        $expected = [
            'who-is-base' => 'i am base',
            'who-am-i' => 'package',
            'base' => [
                'name' => 'base',
            ],
            'checker-1' => [
                'enabled' => false,
                'url' => 'https://package.com',
                'paths' => [
                    '/base',
                    '/package',
                ],
                'something' => 'else',
                'whitelist' => [
                    '/package-1',
                ],
            ],
            'who-is-package' => 'i am package',
            'package' => [
                'name' => 'package',
            ],
        ];

        $this->assertAttributeSame($expected, 'definitions', $actual);
    }

    public function testMergeThreeFiles()
    {
        $actual = ConfigCollectionFactory::makeFromFiles(
            codecept_data_dir('base.toml'),
            codecept_data_dir('package.toml'),
            codecept_data_dir('user.toml')
        );

        $expected = [
            'who-is-base' => 'i am base',
            'who-am-i' => 'user',
            'base' => [
                'name' => 'base',
            ],
            'checker-1' => [
                'enabled' => false,
                'url' => 'https://user.com',
                'paths' => [
                    '/base',
                    '/package',
                    '/user',
                    '/user-2',
                ],
                'something' => 'else',
                'whitelist' => [
                    '/package-1',
                    '/user-1',
                ],
                'nothing' => 'null',
            ],
            'who-is-package' => 'i am package',
            'package' => [
                'name' => 'package',
            ],
            'who-is-user' => 'i am user',
            'user' => [
                'name' => 'user',
            ],
        ];

        $this->assertAttributeSame($expected, 'definitions', $actual);
    }

    public function testMergeInvalidFiles()
    {
        $actual = ConfigCollectionFactory::makeFromFiles(
            codecept_data_dir('base.toml'),
            codecept_root_dir('composer.json'),
            codecept_data_dir('comment.toml'),
            codecept_data_dir('package.toml'),
            codecept_data_dir('empty.toml'),
            codecept_data_dir('user.toml'),
            '/file/not/exist.toml'
        );

        $expected = [
            'who-is-base' => 'i am base',
            'who-am-i' => 'user',
            'base' => [
                'name' => 'base',
            ],
            'checker-1' => [
                'enabled' => false,
                'url' => 'https://user.com',
                'paths' => [
                    '/base',
                    '/package',
                    '/user',
                    '/user-2',
                ],
                'something' => 'else',
                'whitelist' => [
                    '/package-1',
                    '/user-1',
                ],
                'nothing' => 'null',
            ],
            'who-is-package' => 'i am package',
            'package' => [
                'name' => 'package',
            ],
            'who-is-user' => 'i am user',
            'user' => [
                'name' => 'user',
            ],
        ];

        $this->assertAttributeSame($expected, 'definitions', $actual);
    }
}
