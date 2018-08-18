<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\InactivePlugins;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use Mockery;

class InactivePluginsTest extends Unit
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

        $checker = new InactivePlugins();

        $actual = $checker->check(
            new Config([])
        );

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testSuccessWhitelist()
    {
        Mockery::mock('alias:WP_CLI')
               ->expects('runcommand')
               ->with(Mockery::type('string'), Mockery::type('array'))
               ->andReturn([
                   [
                       'name' => 'my-plugin',
                   ],
               ])
               ->once();

        $checker = new InactivePlugins();

        $actual = $checker->check(
            new Config([
                'whitelist' => [
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
                   ],
               ])
               ->once();

        $checker = new InactivePlugins();

        $actual = $checker->check(
            new Config([])
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Inactive plugins found:',
                'my-plugin',
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
                   ],
                   [
                       'name' => 'my-plugin-b',
                   ],
               ])
               ->once();

        $checker = new InactivePlugins();

        $actual = $checker->check(
            new Config([])
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Inactive plugins found:',
                'my-plugin-a',
                'my-plugin-b',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testFailureWhitelist()
    {
        Mockery::mock('alias:WP_CLI')
               ->expects('runcommand')
               ->with(Mockery::type('string'), Mockery::type('array'))
               ->andReturn([
                   [
                       'name' => 'my-plugin-a',
                   ],
                   [
                       'name' => 'my-plugin-b',
                   ],
               ])
               ->once();

        $checker = new InactivePlugins();

        $actual = $checker->check(
            new Config([
                'whitelist' => [
                    'my-plugin-a',
                ],
            ])
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Inactive plugins found:',
                'my-plugin-b',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new InactivePlugins();
    }
}
