<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\OutdatedPackages;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use Mockery;

class OutdatedPackagesTest extends Unit
{
    use AbstractCheckerTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testSuccess()
    {
        Mockery::mock('alias:WP_CLI')
               ->expects('runcommand')
               ->with(Mockery::type('string'), Mockery::type('array'))
               ->andReturn([
                   [
                       'name' => 'my/command',
                       'version' => '1.0.0',
                       'update_version' => '',
                   ],
                   [
                       'name' => 'your/command',
                       'version' => 'dev-master',
                       'update_version' => 'dev-master',
                   ],
               ])
               ->once();

        $checker = new OutdatedPackages();

        $actual = $checker->check(
            new Config([])
        );

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testSuccessExcludes()
    {
        Mockery::mock('alias:WP_CLI')
               ->expects('runcommand')
               ->with(Mockery::type('string'), Mockery::type('array'))
               ->andReturn([
                   [
                       'name' => 'my/command',
                       'version' => '1.0.0',
                       'update_version' => '',
                   ],
                   [
                       'name' => 'your/command',
                       'version' => 'dev-master',
                       'update_version' => 'dev-master',
                   ],
                   [
                       'name' => 'your/command',
                       'version' => 'dev-master',
                       'update_version' => 'dev-master',
                   ],
                   [
                       'name' => 'their/command',
                       'version' => '1.0.0',
                       'update_version' => '2.0.0',
                   ],
               ])
               ->once();

        $checker = new OutdatedPackages();

        $actual = $checker->check(
            new Config([
                'excludes' => [
                    'their/command',
                ],
            ])
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
                       'name' => 'my/command',
                       'version' => '1.0.0',
                       'update_version' => '2.0.0',
                   ],
               ])
               ->once();

        $checker = new OutdatedPackages();

        $actual = $checker->check(
            new Config([])
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'WP CLI package updates available:',
                'my/command (1.0.0 => 2.0.0)',
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
                       'name' => 'my/command',
                       'version' => '1.0.0',
                       'update_version' => '2.0.0',
                   ],
                   [
                       'name' => 'your/command',
                       'version' => '0.1.0.alpha',
                       'update_version' => '2.0.0.beta.123',
                   ],
               ])
               ->once();

        $checker = new OutdatedPackages();

        $actual = $checker->check(
            new Config([])
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'WP CLI package updates available:',
                'my/command (1.0.0 => 2.0.0)',
                'your/command (0.1.0.alpha => 2.0.0.beta.123)',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testFailureExclude()
    {
        Mockery::mock('alias:WP_CLI')
               ->expects('runcommand')
               ->with(Mockery::type('string'), Mockery::type('array'))
               ->andReturn([
                   [
                       'name' => 'my/command',
                       'version' => '1.0.0',
                       'update_version' => '2.0.0',
                   ],
                   [
                       'name' => 'your/command',
                       'version' => '0.1.0.alpha',
                       'update_version' => '2.0.0.beta.123',
                   ],
               ])
               ->once();

        $checker = new OutdatedPackages();

        $actual = $checker->check(
            new Config([
                'excludes' => [
                    'my/command',
                ],
            ])
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'WP CLI package updates available:',
                'your/command (0.1.0.alpha => 2.0.0.beta.123)',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new OutdatedPackages();
    }
}
