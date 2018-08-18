<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\DefinedSaltConstants;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Validators\AbstractValidator;
use Mockery;

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
        $validator = Mockery::mock(AbstractValidator::class);
        $validator->expects('validate')
                  ->withArgs($constantNames)
                  ->andReturn($expected);

        $checker = new DefinedSaltConstants($validator);

        $actual = $checker->check($config);

        $this->assertSame($expected, $actual);
    }

    /**
     * TODO: Move into trait.
     */
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
        $validator = Mockery::mock(AbstractValidator::class);

        return new DefinedSaltConstants($validator);
    }
}
