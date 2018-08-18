<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Results;

use Codeception\Test\Unit;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\Results\AbstractResult;
use Itineris\Preflight\Results\Error;
use Mockery;

class ErrorTest extends Unit
{
    use AbstractResultTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testGetStatus()
    {
        $checker = $checker = Mockery::mock(CheckerInterface::class);

        $result = new Error($checker);

        $expected = $result->getStatus();

        $this->assertSame('Error', $expected);
    }

    protected function getSubject(CheckerInterface $checker, array $messages): AbstractResult
    {
        return new Error($checker, ...$messages);
    }
}
