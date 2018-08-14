<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Results;

use Codeception\Test\Unit;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\AbstractResult;
use Itineris\Preflight\Results\Failure;
use Mockery;

class FailureTest extends Unit
{
    use AbstractResultTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testStatus()
    {
        $checker = $checker = Mockery::mock(CheckerInterface::class);
        $checker->allows('toArray')->andReturn([]);

        $result = new Failure($checker);

        [
            'status' => $status,
        ] = $result->toArray();

        $this->assertSame('Failure', $status);
    }

    protected function getSubject(CheckerInterface $checker): AbstractResult
    {
        return new Failure($checker);
    }

    protected function getSubjectWithMessage(CheckerInterface $checker, ?string $message): AbstractResult
    {
        return new Failure($checker, $message);
    }
}
