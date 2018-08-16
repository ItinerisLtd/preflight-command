<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\BlacklistedUserEmails;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use Itineris\Preflight\Test\Checkers\Trails\CompiledBlacklistAwareTestTrait;
use Mockery;
use WP_Mock;
use WP_User;

class BlacklistedEmailsTest extends Unit
{
    use AbstractCheckerTrail;
    use CompiledBlacklistAwareTestTrait;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testCheckSuccess()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\get_user_by')
               ->with('email', Mockery::type('string'))
               ->andReturnFalse()
               ->twice();

        $config = new Config([]);
        $checker = new BlacklistedUserEmails();

        $actual = $checker->check($config);

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testCheckFailure()
    {
        $wpUser = Mockery::spy(WP_User::class);
        $wpUser->expects('get')
               ->with('user_login')
               ->andReturn('root');
        $wpUser->expects('get')
               ->with('user_email')
               ->andReturn('root@example.test');
        $wpUser->expects('get')
               ->with('ID')
               ->andReturn(456);

        WP_Mock::userFunction('Itineris\Preflight\Checkers\get_user_by')
               ->with('email', 'root@example.test')
               ->andReturn($wpUser)
               ->once();
        WP_Mock::userFunction('Itineris\Preflight\Checkers\get_user_by')
               ->with('email', Mockery::type('string'))
               ->andReturnFalse();

        $config = new Config([]);
        $checker = new BlacklistedUserEmails();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                BlacklistedUserEmails::FAILURE_MESSAGE,
                'ID: 456 root <root@example.test> is blacklisted',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCheckMultipleFailures()
    {
        $wpUser1 = Mockery::spy(WP_User::class);
        $wpUser1->expects('get')
                ->with('user_login')
                ->andReturn('root');
        $wpUser1->expects('get')
                ->with('user_email')
                ->andReturn('root@example.test');
        $wpUser1->expects('get')
                ->with('ID')
                ->andReturn(987);

        $wpUser2 = Mockery::spy(WP_User::class);
        $wpUser2->expects('get')
                ->with('user_login')
                ->andReturn('my-user-123');
        $wpUser2->expects('get')
                ->with('user_email')
                ->andReturn('my-user-123@example.test');
        $wpUser2->expects('get')
                ->with('ID')
                ->andReturn(123);

        WP_Mock::userFunction('Itineris\Preflight\Checkers\get_user_by')
               ->with('email', 'root@example.test')
               ->andReturn($wpUser1)
               ->once();
        WP_Mock::userFunction('Itineris\Preflight\Checkers\get_user_by')
               ->with('email', 'my-user-123@example.test')
               ->andReturn($wpUser2)
               ->once();
        WP_Mock::userFunction('Itineris\Preflight\Checkers\get_user_by')
               ->with('email', Mockery::type('string'))
               ->andReturnFalse();

        $config = new Config([
            'blacklist' => [
                'my-user-123@example.test',
                'no-problem@example.test',
            ],
        ]);
        $checker = new BlacklistedUserEmails();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                BlacklistedUserEmails::FAILURE_MESSAGE,
                'ID: 987 root <root@example.test> is blacklisted',
                'ID: 123 my-user-123 <my-user-123@example.test> is blacklisted',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new BlacklistedUserEmails();
    }
}
