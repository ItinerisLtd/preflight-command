<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Results;

use Codeception\Test\Unit;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\Results\AbstractResult;
use Itineris\Preflight\Results\Success;
use Mockery;

class SuccessTest extends Unit
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

        $result = new Success($checker, []);

        [
            'status' => $status,
        ] = $result->toArray();

        $this->assertSame('Success', $status);
    }

    protected function getSubject(CheckerInterface $checker, array $messages): AbstractResult
    {
        return new Success($checker, $messages);
    }
}
