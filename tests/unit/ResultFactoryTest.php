<?php
namespace Itineris\Preflight\Test;

use Closure;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Disabled;
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
        $make = function($args) {
            return ResultFactory::makeSuccess(...$args);
        };

        $this->testSimpleStringMessages($make);
        $this->testNoMessages($make);
        $this->testNullMessages($make);
        $this->testArrayMessages($make);
    }

    public function testMakeFailure()
    {
        $make = function($args) {
            return ResultFactory::makeFailure(...$args);
        };

        $this->testSimpleStringMessages($make);
        $this->testNoMessages($make);
        $this->testNullMessages($make);
        $this->testArrayMessages($make);
    }

    public function testMakeError()
    {
        $make = function($args) {
            return ResultFactory::makeError(...$args);
        };

        $this->testSimpleStringMessages($make);
        $this->testNoMessages($make);
        $this->testNullMessages($make);
        $this->testArrayMessages($make);
    }

    public function testMakeDisabled()
    {
        $make = function($args) {
            return ResultFactory::makeDisabled(...$args);
        };

        $this->testSimpleStringMessages($make);
        $this->testNoMessages($make);
        $this->testNullMessages($make);
        $this->testArrayMessages($make);
    }

    private function testNullMessages(Closure $make)
    {
        $checker = Mockery::mock(CheckerInterface::class);
        $checker->allows('toArray')->andReturn([]);

        $subject = $make([$checker, null]);

        [
            'messages' => $actual,
        ] = $subject->toArray();

        $this->assertSame([], $actual);
    }

    private function testNoMessages(Closure $make)
    {
        $checker = Mockery::mock(CheckerInterface::class);
        $checker->allows('toArray')->andReturn([]);

        $subject = $make([$checker]);

        [
            'messages' => $actual,
        ] = $subject->toArray();

        $this->assertSame([], $actual);
    }

    private function testSimpleStringMessages(Closure $make)
    {
        $checker = Mockery::mock(CheckerInterface::class);
        $checker->allows('toArray')->andReturn([]);

        $subject = $make([$checker, 'Hello world']);

        [
            'messages' => $actual,
        ] = $subject->toArray();

        $this->assertSame(['Hello world'], $actual);
    }

    private function testArrayMessages(Closure $make)
    {
        $checker = Mockery::mock(CheckerInterface::class);
        $checker->allows('toArray')->andReturn([]);

        $expected = ['Hello world', 'Bye'];
        $subject = $make([$checker, $expected]);

        [
            'messages' => $actual,
        ] = $subject->toArray();

        $this->assertSame($expected, $actual);
    }
}
