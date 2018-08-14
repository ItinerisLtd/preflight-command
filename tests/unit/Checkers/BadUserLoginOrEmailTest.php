<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\Checkers\BadUserLoginOrEmail;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;
use Mockery;
use WP_CLI\Fetchers\User;
use WP_User;

class BadUserLoginOrEmailTest extends Unit
{
    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testImplementCheckerInterface()
    {
        $fetcher = Mockery::mock(User::class);

        $checker = new BadUserLoginOrEmail($fetcher);

        $this->assertInstanceOf(CheckerInterface::class, $checker);
    }

    public function testGetId()
    {
        $fetcher = Mockery::mock(User::class);

        $checker = new BadUserLoginOrEmail($fetcher);

        $actual = $checker->getId();

        $this->assertSame('bad-user-login-or-email', $actual);
    }

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
}
