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

        $actual = ConfigPath::get();

        $this->assertSame('/my/abs/path/preflight.toml', $actual);
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
