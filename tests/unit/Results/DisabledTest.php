<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Results;

use Codeception\Test\Unit;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultInterface;
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

    public function testStatus()
    {
        $checker = $checker = Mockery::mock(CheckerInterface::class);

        $result = new Disabled($checker);

        $actual = $result->getStatus();

        $this->assertSame(ResultInterface::STATUS_SKIP, $actual);
    }

    protected function getSubject(CheckerInterface $checker): AbstractResult
    {
        return new Disabled($checker);
    }

    protected function getSubjectWithMessage(CheckerInterface $checker, ?string $message): AbstractResult
    {
        return new Disabled($checker, $message);
    }
}
