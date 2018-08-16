<?php

namespace Itineris\Preflight\Test;

use Closure;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Disabled;
use Itineris\Preflight\Results\Error;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;
use Mockery;

class ResultFactoryTest extends \Codeception\Test\Unit
{
    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testMakeSuccess()
    {
        $make = function ($args) {
            return ResultFactory::makeSuccess(...$args);
        };

        $this->testSimpleStringMessages($make, Success::class);
        $this->testNoMessages($make, Success::class);
        $this->testNullMessages($make, Success::class);
        $this->testArrayMessages($make, Success::class);
    }

    private function testSimpleStringMessages(Closure $make, string $expectedClass)
    {
        $checker = Mockery::mock(CheckerInterface::class);
        $checker->allows('toArray')->andReturn([]);

        $actual = $make([$checker, 'Hello world']);

        $expected = new $expectedClass($checker, ['Hello world']);

        $this->assertEquals($expected, $actual);
    }

    private function testNoMessages(Closure $make, string $expectedClass)
    {
        $checker = Mockery::mock(CheckerInterface::class);
        $checker->allows('toArray')->andReturn([]);

        $actual = $make([$checker]);

        $expected = new $expectedClass($checker, []);

        $this->assertEquals($expected, $actual);
    }

    private function testNullMessages(Closure $make, string $expectedClass)
    {
        $checker = Mockery::mock(CheckerInterface::class);
        $checker->allows('toArray')->andReturn([]);

        $actual = $make([$checker, null]);

        $expected = new $expectedClass($checker, []);

        $this->assertEquals($expected, $actual);
    }

    private function testArrayMessages(Closure $make, string $expectedClass)
    {
        $checker = Mockery::mock(CheckerInterface::class);
        $checker->allows('toArray')->andReturn([]);

        $message = ['Hello world', 'Bye'];
        $actual = $make([$checker, $message]);

        $expected = new $expectedClass($checker, $message);

        $this->assertEquals($expected, $actual);
    }

    public function testMakeFailure()
    {
        $make = function ($args) {
            return ResultFactory::makeFailure(...$args);
        };

        $this->testSimpleStringMessages($make, Failure::class);
        $this->testNoMessages($make, Failure::class);
        $this->testNullMessages($make, Failure::class);
        $this->testArrayMessages($make, Failure::class);
    }

    public function testMakeError()
    {
        $make = function ($args) {
            return ResultFactory::makeError(...$args);
        };

        $this->testSimpleStringMessages($make, Error::class);
        $this->testNoMessages($make, Error::class);
        $this->testNullMessages($make, Error::class);
        $this->testArrayMessages($make, Error::class);
    }

    public function testMakeDisabled()
    {
        $make = function ($args) {
            return ResultFactory::makeDisabled(...$args);
        };

        $this->testSimpleStringMessages($make, Disabled::class);
        $this->testNoMessages($make, Disabled::class);
        $this->testNullMessages($make, Disabled::class);
        $this->testArrayMessages($make, Disabled::class);
    }
}
