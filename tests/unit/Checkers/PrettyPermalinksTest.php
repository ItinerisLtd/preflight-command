<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\Checkers\PrettyPermalinks;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;
use phpmock\mockery\PHPMockery;

class PrettyPermalinksTest extends Unit
{
    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testImplementCheckerInterface()
    {
        $checker = new PrettyPermalinks();

        $this->assertInstanceOf(CheckerInterface::class, $checker);
    }

    public function testGetId()
    {
        $checker = new PrettyPermalinks();

        $actual = $checker->getId();

        $this->assertSame('pretty-permalinks', $actual);
    }

    public function testCheckSuccess()
    {
        PHPMockery::mock('Itineris\Preflight\Checkers', 'get_option')->andReturn('/%postname%/');

        $checker = new PrettyPermalinks();

        $actual = $checker->check();

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testCheckFailure()
    {
        PHPMockery::mock('Itineris\Preflight\Checkers', 'get_option')->andReturn(false);

        $checker = new PrettyPermalinks();

        $actual = $checker->check();

        $this->assertInstanceOf(Failure::class, $actual);
    }
}
