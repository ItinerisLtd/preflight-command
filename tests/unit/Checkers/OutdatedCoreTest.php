<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\OutdatedCore;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use Mockery;

class OutdatedCoreTest extends \Codeception\Test\Unit
{
    use AbstractCheckerTestTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testSuccess()
    {
        Mockery::mock('alias:WP_CLI')
               ->expects('runcommand')
               ->with(Mockery::type('string'), Mockery::type('array'))
               ->andReturn([])
               ->once();

        $checker = new OutdatedCore();

        $actual = $checker->check(
            new Config([])
        );

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testFailure()
    {
        Mockery::mock('alias:WP_CLI')
               ->expects('runcommand')
               ->with(Mockery::type('string'), Mockery::type('array'))
               ->andReturn([
                   [
                       'version' => '9.8.7',
                       'update_type' => 'minor',
                   ],
               ])
               ->once();

        $checker = new OutdatedCore();

        $actual = $checker->check(
            new Config([])
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'WP core update available:',
                '9.8.7 (minor)',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testMultipleFailure()
    {
        Mockery::mock('alias:WP_CLI')
               ->expects('runcommand')
               ->with(Mockery::type('string'), Mockery::type('array'))
               ->andReturn([
                   [
                       'version' => '9.8.7',
                       'update_type' => 'minor',
                   ],
                   [
                       'version' => '10.0.0',
                       'update_type' => 'major',
                   ],
               ])
               ->once();

        $checker = new OutdatedCore();

        $actual = $checker->check(
            new Config([])
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'WP core update available:',
                '9.8.7 (minor)',
                '10.0.0 (major)',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new OutdatedCore();
    }
}
