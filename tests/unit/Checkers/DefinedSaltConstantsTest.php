<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\DefinedSaltConstants;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use Mockery;

class DefinedSaltConstantsTest extends \Codeception\Test\Unit
{
    use AbstractCheckerTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testCheckSuccess()
    {
        $this->setUpConstants(__FUNCTION__);

        $config = Mockery::mock(Config::class);
        $config->expects('isEnabled')
               ->andReturn(true);
        $config->expects('compileIncludes')
               ->with(DefinedSaltConstants::DEFAULT_INCLUDES)
               ->andReturn([
                   __FUNCTION__ . '_PEPPER_42',
                   __FUNCTION__ . '_PEPPER_LIFE',
                   __FUNCTION__ . '_PEPPER_UNIQUE',
               ])
               ->twice();

        $checker = new DefinedSaltConstants();

        $actual = $checker->check($config);

        $this->assertInstanceOf(Success::class, $actual);
    }

    protected function setUpConstants(string $prefix)
    {
        define($prefix . '_PEPPER_42', 'meaning of life');
        define($prefix . '_PEPPER_LIFE', 'meaning of life');
        define($prefix . '_PEPPER_UNIQUE', 'meaning of after life?');
    }

    public function testCheckFailure()
    {
        $this->setUpConstants(__FUNCTION__);

        $config = Mockery::mock(Config::class);
        $config->expects('isEnabled')
               ->andReturn(true);
        $config->expects('compileIncludes')
               ->with(DefinedSaltConstants::DEFAULT_INCLUDES)
               ->andReturn([
                   __FUNCTION__ . '_PEPPER_42',
                   __FUNCTION__ . '_PEPPER_LIFE',
                   __FUNCTION__ . '_PEPPER_UNIQUE',
                   __FUNCTION__ . '_PEPPER_UNDEFINED_1',
               ])
               ->twice();

        $checker = new DefinedSaltConstants();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Salt constants are not defined:',
                __FUNCTION__ . '_PEPPER_UNDEFINED_1',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCheckFailureMultipleUndefined()
    {
        $this->setUpConstants(__FUNCTION__);

        $config = Mockery::mock(Config::class);
        $config->expects('isEnabled')
               ->andReturn(true);
        $config->expects('compileIncludes')
               ->with(DefinedSaltConstants::DEFAULT_INCLUDES)
               ->andReturn([
                   __FUNCTION__ . '_PEPPER_42',
                   __FUNCTION__ . '_PEPPER_LIFE',
                   __FUNCTION__ . '_PEPPER_UNIQUE',
                   __FUNCTION__ . '_PEPPER_UNDEFINED_1',
                   __FUNCTION__ . '_PEPPER_UNDEFINED_2',
               ])
               ->twice();

        $checker = new DefinedSaltConstants();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Salt constants are not defined:',
                __FUNCTION__ . '_PEPPER_UNDEFINED_1',
                __FUNCTION__ . '_PEPPER_UNDEFINED_2',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCheckEmptyIncludesError()
    {
        $this->setUpConstants(__FUNCTION__);

        $config = new Config([
            'excludes' => DefinedSaltConstants::DEFAULT_INCLUDES,
        ]);
        $checker = new DefinedSaltConstants();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeError($checker, 'Includes is empty.');
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new DefinedSaltConstants();
    }
}
