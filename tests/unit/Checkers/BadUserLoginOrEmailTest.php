<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\BadUserLoginOrEmail;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;
use Mockery;
use WP_CLI\Fetchers\User;
use WP_User;

class BadUserLoginOrEmailTest extends Unit
{
    use AbstractCheckerTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testCheckSuccess()
    {
        $fetcher = Mockery::mock(User::class);
        $fetcher->allows('get')
                ->with(Mockery::type('string'))
                ->andReturnFalse();

        $checker = new BadUserLoginOrEmail($fetcher);

        $actual = $checker->check();

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testCheckFailure()
    {
        $fetcher = Mockery::mock(User::class);
        $wpUser = Mockery::mock(WP_User::class);

        $fetcher->expects('get')
                ->with('admin')
                ->andReturn($wpUser);
        $fetcher->allows('get')
                ->with(Mockery::type('string'))
                ->andReturnFalse();

        $checker = new BadUserLoginOrEmail($fetcher);

        $actual = $checker->check();

        $this->assertInstanceOf(Failure::class, $actual);
    }

    public function testCheckMultipleFailures()
    {
        $fetcher = Mockery::mock(User::class);
        $wpUser1 = Mockery::mock(WP_User::class);
        $wpUser2 = Mockery::mock(WP_User::class);

        $fetcher->expects('get')
                ->with('admin')
                ->andReturn($wpUser1);
        $fetcher->expects('get')
                ->with('root')
                ->andReturn($wpUser2);
        $fetcher->allows('get')
                ->with(Mockery::type('string'))
                ->andReturnFalse();

        $checker = new BadUserLoginOrEmail($fetcher);

        $actual = $checker->check();

        $this->assertInstanceOf(Failure::class, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        $fetcher = Mockery::mock(User::class);

        return new BadUserLoginOrEmail($fetcher);
    }
}
