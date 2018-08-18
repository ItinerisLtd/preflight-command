<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\AllowIndexing;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use WP_Mock;

class AllowIndexingTest extends Unit
{
    use AbstractCheckerTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testCheckSuccess()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\get_option')
               ->andReturn('1');

        $config = new Config([]);
        $checker = new AllowIndexing();

        $actual = $checker->check($config);

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testCheckFailure()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\get_option')
               ->andReturn('0');

        $config = new Config([]);
        $checker = new AllowIndexing();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Indexing not allowed:',
                'Block search engines, but allow normal visitors',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new AllowIndexing();
    }
}
