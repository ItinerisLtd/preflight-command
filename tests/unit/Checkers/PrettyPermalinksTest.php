<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\PrettyPermalinks;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
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

        $config = new Config([]);
        $checker = new PrettyPermalinks();

        $actual = $checker->check($config);

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testCheckFailure()
    {
        WP_Mock::userFunction('get_option')
               ->andReturn(false);

        $config = new Config([]);
        $checker = new PrettyPermalinks();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            'Permalink structure not defined'
        );
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new PrettyPermalinks();
    }
}
