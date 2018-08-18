<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\Sitemap;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use Mockery;
use WP_Mock;

class SitemapTest extends Unit
{
    use AbstractCheckerTestTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testCheckCustomPath()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/my-custom-sitemap.txt')
               ->andReturn('https://example.test/my-custom-sitemap.txt')
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_get')
               ->with('https://example.test/my-custom-sitemap.txt')
               ->andReturn(['fake-status' => 200])
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\is_wp_error')
               ->with(['fake-status' => 200])
               ->andReturnFalse()
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_retrieve_response_code')
               ->with(['fake-status' => 200])
               ->andReturn(200)
               ->once();

        $config = new Config([
            'path' => '/my-custom-sitemap.txt',
        ]);
        $checker = new Sitemap();

        $checker->check($config);
    }

    public function testCheckSuccess()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/sitemap_index.xml')
               ->andReturn('https://example.test/sitemap.xml')
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_get')
               ->with('https://example.test/sitemap.xml')
               ->andReturn(['fake-status' => 200])
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\is_wp_error')
               ->with(['fake-status' => 200])
               ->andReturnFalse()
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_retrieve_response_code')
               ->with(['fake-status' => 200])
               ->andReturn(200)
               ->once();

        $config = new Config([]);
        $checker = new Sitemap();

        $actual = $checker->check($config);

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testCheckFailure403()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/sitemap_index.xml')
               ->andReturn('https://example.test/sitemap.xml')
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_get')
               ->with('https://example.test/sitemap.xml')
               ->andReturn(['fake-status' => 403])
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\is_wp_error')
               ->with(['fake-status' => 403])
               ->andReturnFalse()
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_retrieve_response_code')
               ->with(['fake-status' => 403])
               ->andReturn(403)
               ->once();

        $config = new Config([]);
        $checker = new Sitemap();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            'https://example.test/sitemap.xml returns 403'
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCheckFailureEmptyString()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/sitemap_index.xml')
               ->andReturn('https://example.test/sitemap.xml')
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_get')
               ->with('https://example.test/sitemap.xml')
               ->andReturn(['fake-status' => 503])
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\is_wp_error')
               ->with(['fake-status' => 503])
               ->andReturnFalse()
               ->once();

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_retrieve_response_code')
               ->with(['fake-status' => 503])
               ->andReturn('')
               ->once();

        $config = new Config([]);
        $checker = new Sitemap();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            'Unable to reach https://example.test/sitemap.xml'
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCheckFailureWPError()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/sitemap_index.xml')
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
        $checker = new Sitemap();

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
        return new Sitemap();
    }
}
