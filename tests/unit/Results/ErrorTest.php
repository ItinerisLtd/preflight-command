<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Results;

use Codeception\Test\Unit;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\AbstractResult;
use Itineris\Preflight\Results\Error;
use Mockery;

class ErrorTest extends Unit
{
    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    use AbstractResultTrail;

    public function testStatus()
    {
        $checker = $checker = Mockery::mock(CheckerInterface::class);

        $result = new Error($checker);

        $actual = $result->getStatus();

        $this->assertSame(ResultInterface::STATUS_FAILURE, $actual);
    }

    function getSubject(CheckerInterface $checker): AbstractResult
    {
        return new Error($checker);
    }
}
