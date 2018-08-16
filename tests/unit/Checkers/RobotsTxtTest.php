<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\RobotsTxt;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use Mockery;
use WP_Mock;

class RobotsTxtTest extends Unit
{
    use AbstractCheckerTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testCheckSuccess()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/robots.txt')
               ->andReturn('https://example.test/robots.txt')
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_get')
               ->with('https://example.test/robots.txt')
               ->andReturn(['fake-status-code' => 200])
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\is_wp_error')
               ->with(['fake-status-code' => 200])
               ->andReturnFalse()
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_retrieve_response_code')
               ->with(['fake-status-code' => 200])
               ->andReturn(200)
               ->once();

        $config = new Config([]);
        $checker = new RobotsTxt();

        $actual = $checker->check($config);

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testCheckFailure404()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/robots.txt')
               ->andReturn('https://example.test/robots.txt')
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_get')
               ->with('https://example.test/robots.txt')
               ->andReturn(['fake-status' => 404])
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\is_wp_error')
               ->with(['fake-status' => 404])
               ->andReturnFalse()
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_retrieve_response_code')
               ->with(['fake-status' => 404])
               ->andReturn(404)
               ->once();

        $config = new Config([]);
        $checker = new RobotsTxt();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            'https://example.test/robots.txt returns 404'
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCheckFailureEmptyString()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/robots.txt')
               ->andReturn('https://example.test/robots.txt')
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_get')
               ->with('https://example.test/robots.txt')
               ->andReturn(['fake-status' => 500])
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\is_wp_error')
               ->with(['fake-status' => 500])
               ->andReturnFalse()
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_retrieve_response_code')
               ->with(['fake-status' => 500])
               ->andReturn('')
               ->once();

        $config = new Config([]);
        $checker = new RobotsTxt();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            'Unable to reach https://example.test/robots.txt'
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCheckFailureWPError()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/robots.txt')
               ->andReturn('https://example.test/sitemap.xml')
               ->once();

        $wpError = Mockery::mock();
        $wpError->expects('get_error_messages')
                ->withNoArgs()
                ->andReturn(['AA', 'BB'])
                ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_get')
               ->with('https://example.test/sitemap.xml')
               ->andReturn($wpError)
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\is_wp_error')
               ->with($wpError)
               ->andReturnTrue()
               ->once();

        $config = new Config([]);
        $checker = new RobotsTxt();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Unable to reach https://example.test/sitemap.xml',
                'AA',
                'BB',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new RobotsTxt();
    }
}
