<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\UniqueSaltConstants;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use Mockery;

class UniqueSaltConstantsTest extends Unit
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
               ->with(UniqueSaltConstants::DEFAULT_INCLUDES)
               ->andReturn([
                   __FUNCTION__ . '_SALT_42',
                   __FUNCTION__ . '_SALT_UNIQUE',
                   __FUNCTION__ . '_SALT_UNDEFINED_1',
               ])
               ->twice();

        $checker = new UniqueSaltConstants();

        $actual = $checker->check($config);

        $this->assertInstanceOf(Success::class, $actual);
    }

    protected function setUpConstants(string $prefix)
    {
        define($prefix . '_SALT_42', 'meaning of life');
        define($prefix . '_SALT_LIFE', 'meaning of life');
        define($prefix . '_SALT_UNIQUE', 'meaning of after life?');
    }

    public function testCheckFailureTwoNotDefined()
    {
        $this->setUpConstants(__FUNCTION__);

        $config = Mockery::mock(Config::class);
        $config->expects('isEnabled')
               ->andReturn(true);
        $config->expects('compileIncludes')
               ->with(UniqueSaltConstants::DEFAULT_INCLUDES)
               ->andReturn([
                   __FUNCTION__ . '_SALT_42',
                   __FUNCTION__ . '_SALT_UNIQUE',
                   __FUNCTION__ . '_SALT_UNDEFINED_1',
                   __FUNCTION__ . '_SALT_UNDEFINED_2',
               ])
               ->twice();

        $checker = new UniqueSaltConstants();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Salt constant values are not unique (or not defined):',
                __FUNCTION__ . '_SALT_UNDEFINED_1',
                __FUNCTION__ . '_SALT_UNDEFINED_2',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCheckFailureDuplicated()
    {
        $this->setUpConstants(__FUNCTION__);

        $config = Mockery::mock(Config::class);
        $config->expects('isEnabled')
               ->andReturn(true);
        $config->expects('compileIncludes')
               ->with(UniqueSaltConstants::DEFAULT_INCLUDES)
               ->andReturn([
                   __FUNCTION__ . '_SALT_42',
                   __FUNCTION__ . '_SALT_LIFE',
                   __FUNCTION__ . '_SALT_UNIQUE',
                   __FUNCTION__ . '_SALT_UNDEFINED_1',
               ])
               ->twice();

        $checker = new UniqueSaltConstants();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Salt constant values are not unique (or not defined):',
                __FUNCTION__ . '_SALT_42',
                __FUNCTION__ . '_SALT_LIFE',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCheckEpicFailure()
    {
        $this->setUpConstants(__FUNCTION__);

        $config = Mockery::mock(Config::class);
        $config->expects('isEnabled')
               ->andReturn(true);
        $config->expects('compileIncludes')
               ->with(UniqueSaltConstants::DEFAULT_INCLUDES)
               ->andReturn([
                   __FUNCTION__ . '_SALT_42',
                   __FUNCTION__ . '_SALT_LIFE',
                   __FUNCTION__ . '_SALT_UNIQUE',
                   __FUNCTION__ . '_SALT_UNDEFINED_1',
                   __FUNCTION__ . '_SALT_UNDEFINED_2',
               ])
               ->twice();

        $checker = new UniqueSaltConstants();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Salt constant values are not unique (or not defined):',
                __FUNCTION__ . '_SALT_42',
                __FUNCTION__ . '_SALT_LIFE',
                __FUNCTION__ . '_SALT_UNDEFINED_1',
                __FUNCTION__ . '_SALT_UNDEFINED_2',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCheckEmptyIncludesError()
    {
        $this->setUpConstants(__FUNCTION__);

        $config = new Config([
            'excludes' => UniqueSaltConstants::DEFAULT_INCLUDES,
        ]);
        $checker = new UniqueSaltConstants();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeError($checker, 'Includes is empty.');
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new UniqueSaltConstants();
    }
}
