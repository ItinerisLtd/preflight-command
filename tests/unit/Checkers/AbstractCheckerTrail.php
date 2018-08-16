<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Itineris\Preflight\CheckerCollection;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Config;
use Itineris\Preflight\Results\Disabled;
use Mockery;

trait AbstractCheckerTrail
{
    public function testGetId()
    {
        $subject = $this->getSubject();

        $actual = $subject->getId();

        $this->assertSame($subject::ID, $actual);
    }

    public function testGetLink()
    {
        $subject = $this->getSubject();

        $actual = $subject->getLink();

        $this->assertSame($subject::LINK_BASE . $subject::ID . '/', $actual);
    }

    public function testGetDescription()
    {
        $subject = $this->getSubject();

        $actual = $subject->getDescription();

        $this->assertSame($subject::DESCRIPTION, $actual);
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

    public function testCheckDisabled()
    {
        $config = new Config([
            'enabled' => false,
        ]);

        $subject = $this->getSubject();

        $actual = $subject->check($config);

        $this->assertInstanceOf(Disabled::class, $actual);
    }

    abstract protected function getSubject(): AbstractChecker;
}
