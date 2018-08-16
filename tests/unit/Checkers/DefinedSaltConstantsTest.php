<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\DefinedSaltConstants;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Validators\DefinedConstants;
use Mockery;
use WP_Mock;

class DefinedSaltConstantsTest extends \Codeception\Test\Unit
{
    use AbstractCheckerTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testUsingDefinedConstantsValidator()
    {
        $constantNames = ['AAA', 'BBB'];
        $config = Mockery::mock(Config::class);
        $config->expects('isEnabled')
               ->withNoArgs()
               ->andReturnTrue()
               ->once();
        $config->expects('compileIncludes')
               ->withArgs([DefinedSaltConstants::DEFAULT_INCLUDES])
               ->andReturn($constantNames)
               ->twice();

        $expected = Mockery::mock(ResultInterface::class);
        $validator = Mockery::mock(DefinedConstants::class);
        $validator->expects('validate')
                  ->withArgs($constantNames)
                  ->andReturn($expected);

        $checker = new DefinedSaltConstants();

        WP_Mock::userFunction('Itineris\Preflight\Validators\apply_filters')
               ->with(DefinedConstants::MAKE_HOOK, Mockery::type(DefinedConstants::class), $checker, Mockery::any())
               ->andReturn($validator)
               ->once();

        $actual = $checker->check($config);

        $this->assertSame($expected, $actual);
    }

    public function testCheckEmptyIncludesError()
    {
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
