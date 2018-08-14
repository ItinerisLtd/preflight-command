<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Itineris\Preflight\CheckerCollection;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\Checkers\AbstractChecker;
use Mockery;

trait AbstractCheckerTrail
{
    public function testGetId()
    {
        $subject = $this->getSubject();

        $actual = $subject->getId();

        $this->assertSame($subject::ID, $actual);
    }

    public function testToArray()
    {
        $subject = $this->getSubject();

        $actual = $subject->toArray();

        $expected = [
            'id' => $subject::ID,
            'link' => $subject::LINK_BASE . $subject::ID . '/',
            'description' => $subject::DESCRIPTION,
        ];
        $this->assertSame($expected, $actual);
    }

    public function testImplementCheckerInterface()
    {
        $subject = $this->getSubject();

        $this->assertInstanceOf(CheckerInterface::class, $subject);
    }

    public function testExtendAbstractChecker()
    {
        $subject = $this->getSubject();

        $this->assertInstanceOf(AbstractChecker::class, $subject);
    }

    public function testRegister()
    {
        $subject = $this->getSubject();

        $checkerCollection = Mockery::mock(CheckerCollection::class);
        $checkerCollection->expects('set')
                          ->with(Mockery::type(get_class($subject)))
                          ->once();

        $subject::register($checkerCollection);
    }

    abstract protected function getSubject(): AbstractChecker;
}
