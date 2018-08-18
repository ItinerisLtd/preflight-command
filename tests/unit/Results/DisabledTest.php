<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Results;

use Codeception\Test\Unit;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\Results\AbstractResult;
use Itineris\Preflight\Results\Disabled;
use Mockery;

class DisabledTest extends Unit
{
    use AbstractResultTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testGetStatus()
    {
        $checker = Mockery::mock(CheckerInterface::class);

        $result = new Disabled($checker);

        $expected = $result->getStatus();

        $this->assertSame('Disabled', $expected);
    }

    protected function getSubject(CheckerInterface $checker, array $messages): AbstractResult
    {
        return new Disabled($checker, ...$messages);
    }
}
