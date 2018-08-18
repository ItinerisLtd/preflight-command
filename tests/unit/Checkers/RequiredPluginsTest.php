<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\RequiredPlugins;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use Itineris\Preflight\Test\Checkers\Trails\CompiledIncludesAwareTestTrait;
use Mockery;

class RequiredPluginsTest extends Unit
{
    use AbstractCheckerTrail;
    use CompiledIncludesAwareTestTrait;

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
                       'name' => 'my-plugin',
                   ],
               ])
               ->once();

        $checker = new RequiredPlugins();

        $actual = $checker->check(
            new Config([
                'includes' => 'my-plugin'
            ])
        );

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testFailure()
    {
        Mockery::mock('alias:WP_CLI')
               ->expects('runcommand')
               ->with(Mockery::type('string'), Mockery::type('array'))
               ->andReturn([])
               ->once();

        $checker = new RequiredPlugins();

        $actual = $checker->check(
            new Config([
                'includes' => 'my-plugin',
            ])
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Required plugins not found:',
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
               ])
               ->once();

        $checker = new RequiredPlugins();

        $actual = $checker->check(
            new Config([
                'includes' => [
                    'my-plugin-a',
                    'my-plugin-b',
                    'my-plugin-c',
                ],
            ])
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Required plugins not found:',
                'my-plugin-b',
                'my-plugin-c',
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
                   ],
               ])
               ->once();

        $checker = new RequiredPlugins();

        $actual = $checker->check(
            new Config([
                'includes' => [
                    'my-plugin-a',
                    'my-plugin-b',
                    'my-plugin-c',
                ],
                'excludes' => [
                    'my-plugin-b',
                ],
            ])
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Required plugins not found:',
                'my-plugin-c',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new RequiredPlugins();
    }
}
