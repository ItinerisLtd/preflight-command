<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\PrettyPermalinks;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;
use WP_Mock;

class PrettyPermalinksTest extends Unit
{
    use AbstractCheckerTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testCheckSuccess()
    {
        WP_Mock::userFunction('get_option')
               ->andReturn('/%postname%/');

        $checker = new PrettyPermalinks();

        $actual = $checker->check();

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testCheckFailure()
    {
        WP_Mock::userFunction('get_option')
               ->andReturn(false);

        $checker = new PrettyPermalinks();

        $actual = $checker->check();

        $this->assertInstanceOf(Failure::class, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new PrettyPermalinks();
    }
}
