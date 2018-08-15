<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\BadUserLoginOrEmail;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
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

        $config = new Config([]);
        $checker = new BadUserLoginOrEmail($fetcher);

        $actual = $checker->check($config);

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testCheckFailure()
    {
        $wpUser = Mockery::spy(WP_User::class);
        $wpUser->expects('get')
               ->with('user_login')
               ->andReturn('my-user-123');
        $wpUser->expects('get')
               ->with('user_email')
               ->andReturn('root@example.test');
        $wpUser->expects('get')
               ->with('ID')
               ->andReturn(123);

        $fetcher = Mockery::mock(User::class);
        $fetcher->expects('get')
                ->with('root@example.test')
                ->andReturn($wpUser);
        $fetcher->allows('get')
                ->with(Mockery::type('string'))
                ->andReturnFalse();

        $config = new Config([
            'blacklist' => [
                'root@example.test',
            ],
        ]);
        $checker = new BadUserLoginOrEmail($fetcher);

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            "User: my-user-123 <root@example.test> (ID: 123) is blacklisted"
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCheckMultipleFailures()
    {
        $wpUser1 = Mockery::spy(WP_User::class);
        $wpUser1->expects('get')
                ->with('user_login')
                ->andReturn('admin');
        $wpUser1->expects('get')
                ->with('user_email')
                ->andReturn('admin@example.test');
        $wpUser1->expects('get')
                ->with('ID')
                ->andReturn(987);

        $wpUser2 = Mockery::spy(WP_User::class);
        $wpUser2->expects('get')
                ->with('user_login')
                ->andReturn('my-user-123');
        $wpUser2->expects('get')
                ->with('user_email')
                ->andReturn('root@example.test');
        $wpUser2->expects('get')
                ->with('ID')
                ->andReturn(123);

        $fetcher = Mockery::mock(User::class);
        $fetcher->expects('get')
                ->with('admin')
                ->andReturn($wpUser1);
        $fetcher->expects('get')
                ->with('root@example.test')
                ->andReturn($wpUser2);
        $fetcher->allows('get')
                ->with(Mockery::type('string'))
                ->andReturnFalse();

        $config = new Config([
            'blacklist' => [
                'root@example.test',
            ],
        ]);
        $checker = new BadUserLoginOrEmail($fetcher);

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                "User: admin <admin@example.test> (ID: 987) is blacklisted",
                "User: my-user-123 <root@example.test> (ID: 123) is blacklisted",
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCheckEmptyBlacklistError()
    {
        $fetcher = Mockery::mock(User::class);

        $config = new Config([
            'whitelist' => BadUserLoginOrEmail::DEFAULT_BLACKLIST,
        ]);
        $checker = new BadUserLoginOrEmail($fetcher);

        $actual = $checker->check($config);

        $expected = ResultFactory::makeError($checker, 'Blacklist is empty.');
        $this->assertEquals($expected, $actual);
    }

    public function testCheckNumericItemError()
    {
        $fetcher = Mockery::mock(User::class);

        $config = new Config([
            'blacklist' => [
                123,
            ],
        ]);
        $checker = new BadUserLoginOrEmail($fetcher);

        $actual = $checker->check($config);

        $expected = ResultFactory::makeError($checker, 'Blacklist cannot contains numeric items');
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        $fetcher = Mockery::mock(User::class);

        return new BadUserLoginOrEmail($fetcher);
    }
}
