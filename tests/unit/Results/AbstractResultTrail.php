<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Results;

use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\AbstractResult;
use Mockery;

trait AbstractResultTrail
{
    public function testToArrayContainsCheckerInfo()
    {
        $checkerArray = [
            'a' => 'b',
            'c' => 'd',
        ];
        $checker = $checker = Mockery::mock(CheckerInterface::class);
        $checker->shouldReceive('toArray')->andReturn($checkerArray);

        $subject = $this->getSubject($checker, []);

        $actual = $subject->toArray();

        $this->assertArraySubset($checkerArray, $actual);
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
        $checker->allows('toArray')->andReturn([]);

        $expected = ['Hello world', 'Good luck'];
        $subject = $this->getSubject($checker, $expected);

        [
            'messages' => $actual,
        ] = $subject->toArray();

        $this->assertSame($expected, $actual);
    }

    abstract protected function getSubject(CheckerInterface $checker, array $messages): AbstractResult;
}
