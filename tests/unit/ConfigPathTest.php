<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test;

use Codeception\Test\Unit;
use Itineris\Preflight\ConfigPath;
use WP_Mock;

class ConfigPathTest extends Unit
{
    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testGetPreflightDir()
    {
        WP_Mock::userFunction('Itineris\Preflight\defined')
               ->with('PREFLIGHT_DIR')
               ->andReturnTrue()
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\constant')
               ->with('PREFLIGHT_DIR')
               ->andReturn('/my/preflight/dir/')
               ->once();

        WP_Mock::passthruFunction('WP_CLI\Utils\trailingslashit');
        WP_Mock::passthruFunction('WP_CLI\Utils\normalize_path');

        $actual = ConfigPath::get();

        $this->assertSame('/my/preflight/dir/preflight.toml', $actual);
    }

    public function testGetAbsPath()
    {
        WP_Mock::userFunction('Itineris\Preflight\defined')
               ->with('PREFLIGHT_DIR')
               ->andReturnFalse()
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\defined')
               ->with('ABSPATH')
               ->andReturnTrue()
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\constant')
               ->with('ABSPATH')
               ->andReturn('/my/abs/path/')
               ->once();

        WP_Mock::passthruFunction('WP_CLI\Utils\trailingslashit');
        WP_Mock::passthruFunction('WP_CLI\Utils\normalize_path');

        $actual = ConfigPath::get();

        $this->assertSame('/my/abs/path/preflight.toml', $actual);
    }

    public function testGetTrailingSlashIt()
    {
        WP_Mock::userFunction('Itineris\Preflight\defined')
               ->with('PREFLIGHT_DIR')
               ->andReturnTrue()
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\constant')
               ->with('PREFLIGHT_DIR')
               ->andReturn('/my/path')
               ->once();

        WP_Mock::userFunction('WP_CLI\Utils\trailingslashit')
               ->with('/my/path')
               ->andReturn('/my/path/')
               ->once();

        WP_Mock::passthruFunction('WP_CLI\Utils\normalize_path');

        $actual = ConfigPath::get();

        $this->assertSame('/my/path/preflight.toml', $actual);
    }

    public function testGetNormalizePath()
    {
        WP_Mock::userFunction('Itineris\Preflight\defined')
               ->with('PREFLIGHT_DIR')
               ->andReturnTrue()
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\constant')
               ->with('PREFLIGHT_DIR')
               ->andReturn('/my/preflight/dir/')
               ->once();

        WP_Mock::passthruFunction('WP_CLI\Utils\trailingslashit');

        WP_Mock::userFunction('WP_CLI\Utils\normalize_path')
               ->with('/my/preflight/dir/preflight.toml')
               ->andReturn('/my/normalized/dir/preflight.toml')
               ->once();

        $actual = ConfigPath::get();

        $this->assertSame('/my/normalized/dir/preflight.toml', $actual);
    }

    public function testGetNotDefined()
    {
        WP_Mock::userFunction('Itineris\Preflight\defined')
               ->with('PREFLIGHT_DIR')
               ->andReturnFalse()
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\defined')
               ->with('ABSPATH')
               ->andReturnFalse()
               ->once();

        $actual = ConfigPath::get();

        $this->assertNull($actual);
    }
}
