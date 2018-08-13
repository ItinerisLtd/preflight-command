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

    abstract function getSubject(CheckerInterface $checker): AbstractResult;
}
