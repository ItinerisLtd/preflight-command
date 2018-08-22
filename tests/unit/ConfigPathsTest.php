<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test;

use Codeception\Test\Unit;
use Itineris\Preflight\ConfigPaths;
use WP_Mock;

class ConfigPathsTest extends Unit
{
    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testAllApplyFilter()
    {
        WP_Mock::expectFilter(ConfigPaths::HOOK, []);

        $actual = ConfigPaths::all();

        $this->assertSame([], $actual);
    }

    public function testAll()
    {
        WP_Mock::userFunction('Itineris\Preflight\file_exists')
               ->with('/first/path/preflight.toml')
               ->andReturnTrue()
               ->once();
        WP_Mock::userFunction('Itineris\Preflight\file_exists')
               ->with('/third/path/preflight.toml')
               ->andReturnTrue()
               ->once();
        WP_Mock::userFunction('Itineris\Preflight\file_exists')
               ->withAnyArgs()
               ->andReturnFalse()
               ->twice();

        $paths = [
            '/first/path/preflight.toml',
            '/second/path/preflight.toml',
            '',
            '/third/path/preflight.toml',
        ];

        WP_Mock::onFilter(ConfigPaths::HOOK)
               ->with([])
               ->reply($paths);

        $actual = ConfigPaths::all();

        $this->assertSame([
            '/first/path/preflight.toml',
            '/third/path/preflight.toml',
        ], $actual);
    }

    public function testMergeDefaultPath()
    {
        $paths = [
            '/first/path/preflight.toml',
            '/second/path/preflight.toml',
        ];

        $actual = ConfigPaths::mergeDefaultPath($paths);

        $expected = [
            '/first/path/preflight.toml',
            '/second/path/preflight.toml',
            codecept_root_dir('config/default.toml'),
        ];

        $this->assertSame($expected, $actual);
    }

    public function testMergeAbsPath()
    {
        WP_Mock::userFunction('Itineris\Preflight\defined')
               ->with('ABSPATH')
               ->andReturnTrue()
               ->once();

        $absPath = '/my/abs/path/';
        WP_Mock::userFunction('Itineris\Preflight\constant')
               ->with('ABSPATH')
               ->andReturn($absPath)
               ->once();

        $paths = [
            '/first/path/preflight.toml',
            '/second/path/preflight.toml',
        ];

        $actual = ConfigPaths::mergeAbsPath($paths);

        $expected = [
            '/first/path/preflight.toml',
            '/second/path/preflight.toml',
            '/my/abs/path/preflight.toml',
        ];

        $this->assertSame($expected, $actual);
    }

    public function testMergeAbsPathNotDefined()
    {
        WP_Mock::userFunction('Itineris\Preflight\defined')
               ->with('ABSPATH')
               ->andReturnFalse()
               ->once();

        $paths = [
            '/first/path/preflight.toml',
            '/second/path/preflight.toml',
        ];

        $actual = ConfigPaths::mergeAbsPath($paths);

        $this->assertSame($paths, $actual);
    }

    public function testMergePreflightDir()
    {
        WP_Mock::userFunction('Itineris\Preflight\defined')
               ->with('PREFLIGHT_DIR')
               ->andReturnTrue()
               ->once();

        $preflightDir = '/my/preflight/dir/';
        WP_Mock::userFunction('Itineris\Preflight\constant')
               ->with('PREFLIGHT_DIR')
               ->andReturn($preflightDir)
               ->once();

        $paths = [
            '/first/path/preflight.toml',
            '/second/path/preflight.toml',
        ];

        $actual = ConfigPaths::mergePreflightDir($paths);

        $expected = [
            '/first/path/preflight.toml',
            '/second/path/preflight.toml',
            '/my/preflight/dir/preflight.toml',
        ];

        $this->assertSame($expected, $actual);
    }

    public function testMergePreflightDirNotDefined()
    {
        WP_Mock::userFunction('Itineris\Preflight\defined')
               ->with('PREFLIGHT_DIR')
               ->andReturnFalse()
               ->once();

        $paths = [
            '/first/path/preflight.toml',
            '/second/path/preflight.toml',
        ];

        $actual = ConfigPaths::mergePreflightDir($paths);

        $this->assertSame($paths, $actual);
    }

    protected function _before()
    {
        WP_Mock::passthruFunction('WP_CLI\Utils\trailingslashit');
        WP_Mock::passthruFunction('WP_CLI\Utils\normalize_path');
    }
}
