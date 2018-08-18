<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\OutdatedPlugins;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use Mockery;

class OutdatedPluginsTest extends Unit
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
               ->andReturn([])
               ->once();

        $checker = new OutdatedPlugins();

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
                       'name' => 'my-plugin',
                       'version' => '1.0.0',
                       'update_version' => '2.0.0',
                   ],
               ])
               ->once();

        $checker = new OutdatedPlugins();

        $actual = $checker->check(
            new Config([
                'excludes' => [
                    'my-plugin',
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
                       'name' => 'my-plugin',
                       'version' => '1.0.0',
                       'update_version' => '2.0.0',
                   ],
               ])
               ->once();

        $checker = new OutdatedPlugins();

        $actual = $checker->check(
            new Config([])
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Plugin updates available:',
                'my-plugin (1.0.0 => 2.0.0)',
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
                       'name' => 'my-plugin-a',
                       'version' => '1.0.0',
                       'update_version' => '2.0.0',
                   ],
                   [
                       'name' => 'my-plugin-b',
                       'version' => '0.1.0.alpha',
                       'update_version' => '2.0.0.beta.123',
                   ],
               ])
               ->once();

        $checker = new OutdatedPlugins();

        $actual = $checker->check(
            new Config([])
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Plugin updates available:',
                'my-plugin-a (1.0.0 => 2.0.0)',
                'my-plugin-b (0.1.0.alpha => 2.0.0.beta.123)',
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
                       'name' => 'my-plugin-a',
                       'version' => '1.0.0',
                       'update_version' => '2.0.0',
                   ],
                   [
                       'name' => 'my-plugin-b',
                       'version' => '0.1.0.alpha',
                       'update_version' => '2.0.0.beta.123',
                   ],
               ])
               ->once();

        $checker = new OutdatedPlugins();

        $actual = $checker->check(
            new Config([
                'excludes' => [
                    'my-plugin-a',
                ],
            ])
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Plugin updates available:',
                'my-plugin-b (0.1.0.alpha => 2.0.0.beta.123)',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new OutdatedPlugins();
    }
}
