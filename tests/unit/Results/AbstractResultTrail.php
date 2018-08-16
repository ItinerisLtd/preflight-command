<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Results;

use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\AbstractResult;
use Mockery;

trait AbstractResultTrail
{
    public function testGetChecker()
    {
        $expected = Mockery::mock(CheckerInterface::class);

        $subject = $this->getSubject($expected, []);

        $actual = $subject->getChecker();

        $this->assertSame($expected, $actual);
    }

    public function testImplementResultInterface()
    {
        $checker = Mockery::mock(CheckerInterface::class);

        $subject = $this->getSubject($checker, []);

        $this->assertInstanceOf(ResultInterface::class, $subject);
    }

    public function testExtendAbstractResult()
    {
        $checker = Mockery::mock(CheckerInterface::class);

        $subject = $this->getSubject($checker, []);

        $this->assertInstanceOf(AbstractResult::class, $subject);
    }

    public function testGetMessages()
    {
        $checker = Mockery::mock(CheckerInterface::class);

        $expected = ['Hello world', 'Good luck'];
        $subject = $this->getSubject($checker, $expected);

        $actual = $subject->getMessages();

        $this->assertSame($expected, $actual);
    }

    abstract protected function getSubject(CheckerInterface $checker, array $messages): AbstractResult;
}
