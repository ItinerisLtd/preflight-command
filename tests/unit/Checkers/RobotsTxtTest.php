<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\RobotsTxt;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
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
        WP_Mock::userFunction('home_url')
               ->with('/robots.txt')
               ->andReturn('https://example.test/robots.txt');

        WP_Mock::userFunction('wp_remote_get')
               ->with('https://example.test/robots.txt')
               ->andReturn(['fake-status' => 200]);

        WP_Mock::userFunction('wp_remote_retrieve_response_code')
               ->with(['fake-status' => 200])
               ->andReturn(200);

        $config = new Config([]);
        $checker = new RobotsTxt();

        $actual = $checker->check($config);

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testCheckFailure404()
    {
        WP_Mock::userFunction('home_url')
               ->with('/robots.txt')
               ->andReturn('https://example.test/robots.txt');

        WP_Mock::userFunction('wp_remote_get')
               ->with('https://example.test/robots.txt')
               ->andReturn(['fake-status' => 404]);

        WP_Mock::userFunction('wp_remote_retrieve_response_code')
               ->with(['fake-status' => 404])
               ->andReturn(404);

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
        WP_Mock::userFunction('home_url')
               ->with('/robots.txt')
               ->andReturn('https://example.test/robots.txt');

        WP_Mock::userFunction('wp_remote_get')
               ->with('https://example.test/robots.txt')
               ->andReturn(['fake-status' => 404]);

        WP_Mock::userFunction('wp_remote_retrieve_response_code')
               ->with(['fake-status' => 404])
               ->andReturn('');

        $config = new Config([]);
        $checker = new RobotsTxt();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            'Unable to reach https://example.test/robots.txt'
        );
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new RobotsTxt();
    }
}
