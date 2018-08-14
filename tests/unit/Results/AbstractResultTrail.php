<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Results;

use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\AbstractResult;
use Mockery;

trait AbstractResultTrail
{
    public function testGetCheckerId()
    {
        $checker = $checker = Mockery::mock(CheckerInterface::class);
        $checker->shouldReceive('getId')->andReturn('my-checker');

        $subject = $this->getSubject($checker);

        $actual = $subject->getCheckerId();

        $this->assertSame('my-checker', $actual);
    }

    public function testImplementResultInterface()
    {
        $checker = Mockery::mock(CheckerInterface::class);

        $subject = $this->getSubject($checker);

        $this->assertInstanceOf(ResultInterface::class, $subject);
    }

    public function testExtendAbstractResult()
    {
        $checker = Mockery::mock(CheckerInterface::class);

        $subject = $this->getSubject($checker);

        $this->assertInstanceOf(AbstractResult::class, $subject);
    }

    public function testNullMessage()
    {
        $checker = Mockery::mock(CheckerInterface::class);

        $subject = $this->getSubjectWithMessage($checker, null);

        $actual = $subject->getMessage();

        $this->assertSame('', $actual);
    }

    public function testNoMessage()
    {
        $checker = Mockery::mock(CheckerInterface::class);

        $subject = $this->getSubject($checker);

        $actual = $subject->getMessage();

        $this->assertSame('', $actual);
    }

    public function testGetMessage()
    {
        $checker = Mockery::mock(CheckerInterface::class);

        $subject = $this->getSubjectWithMessage($checker, 'Hello world');

        $actual = $subject->getMessage();

        $this->assertSame('Hello world', $actual);
    }

    abstract protected function getSubject(CheckerInterface $checker): AbstractResult;

    abstract protected function getSubjectWithMessage(CheckerInterface $checker, ?string $message): AbstractResult;
}
