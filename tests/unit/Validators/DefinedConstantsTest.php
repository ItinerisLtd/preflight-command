<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Validators;

use Codeception\Test\Unit;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use Itineris\Preflight\Validators\AbstractValidator;
use Itineris\Preflight\Validators\DefinedConstants;
use Mockery;

class DefinedConstantsTest extends Unit
{
    use AbstractValidatorTestTrait;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testCheckSuccess()
    {
        $this->setUpConstants(__FUNCTION__);

        $checker = Mockery::mock(CheckerInterface::class);

        $validator = new DefinedConstants($checker);

        $actual = $validator->validate(
            __FUNCTION__ . '_SUGAR_42',
            __FUNCTION__ . '_SUGAR_LIFE',
            __FUNCTION__ . '_SUGAR_UNIQUE'
        );

        $this->assertInstanceOf(Success::class, $actual);
    }

    protected function setUpConstants(string $prefix)
    {
        define($prefix . '_SUGAR_42', 'meaning of life');
        define($prefix . '_SUGAR_LIFE', 'meaning of life');
        define($prefix . '_SUGAR_UNIQUE', 'meaning of after life?');
    }

    public function testCheckFailure()
    {
        $this->setUpConstants(__FUNCTION__);

        $checker = Mockery::mock(CheckerInterface::class);

        $validator = new DefinedConstants($checker);

        $actual = $validator->validate(
            __FUNCTION__ . '_SUGAR_42',
            __FUNCTION__ . '_SUGAR_LIFE',
            __FUNCTION__ . '_SUGAR_UNDEFINED_1'
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Constants are not defined:',
                __FUNCTION__ . '_SUGAR_UNDEFINED_1',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCheckFailureMultipleUndefined()
    {
        $this->setUpConstants(__FUNCTION__);

        $checker = Mockery::mock(CheckerInterface::class);

        $validator = new DefinedConstants($checker);

        $actual = $validator->validate(
            __FUNCTION__ . '_SUGAR_42',
            __FUNCTION__ . '_SUGAR_UNDEFINED_1',
            __FUNCTION__ . '_SUGAR_LIFE',
            __FUNCTION__ . '_SUGAR_UNDEFINED_2'
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Constants are not defined:',
                __FUNCTION__ . '_SUGAR_UNDEFINED_1',
                __FUNCTION__ . '_SUGAR_UNDEFINED_2',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(CheckerInterface $checker, string $message): AbstractValidator
    {
        return new DefinedConstants($checker, $message);
    }
}
