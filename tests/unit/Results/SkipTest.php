<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Results;

use Codeception\Test\Unit;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\AbstractResult;
use Itineris\Preflight\Results\Skip;
use Mockery;

class SkipTest extends Unit
{
    use AbstractResultTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testStatus()
    {
        $checker = $checker = Mockery::mock(CheckerInterface::class);

        $result = new Skip($checker);

        $actual = $result->getStatus();

        $this->assertSame(ResultInterface::STATUS_SKIP, $actual);
    }

    protected function getSubject(CheckerInterface $checker): AbstractResult
    {
        return new Skip($checker);
    }

    protected function getSubjectWithMessage(CheckerInterface $checker, ?string $message): AbstractResult
    {
        return new Skip($checker, $message);
    }
}
