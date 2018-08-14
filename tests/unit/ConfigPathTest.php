<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test;

use Codeception\Test\Unit;
use Itineris\Preflight\ConfigPath;

class ConfigPathTest extends Unit
{
    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testGet()
    {
        $actual = ConfigPath::get();

        $expected = ABSPATH . 'preflight.toml';

        $this->assertSame($expected, $actual);
    }
}
