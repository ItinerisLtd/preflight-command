<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\Sitemap;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use WP_Mock;

class SitemapTest extends Unit
{
    use AbstractCheckerTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testCheckCustomPath()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/my-custom-sitemap.txt')
               ->andReturn('https://example.test/my-custom-sitemap.txt');

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_get')
               ->with('https://example.test/my-custom-sitemap.txt')
               ->andReturn(['fake-status' => 200]);

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_retrieve_response_code')
               ->with(['fake-status' => 200])
               ->andReturn(200);

        $config = new Config([
            'path' => '/my-custom-sitemap.txt',
        ]);
        $checker = new Sitemap();

        $checker->check($config);
    }

    public function testCheckSuccess()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/sitemap.xml')
               ->andReturn('https://example.test/sitemap.xml');

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_get')
               ->with('https://example.test/sitemap.xml')
               ->andReturn(['fake-status' => 200]);

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_retrieve_response_code')
               ->with(['fake-status' => 200])
               ->andReturn(200);

        $config = new Config([]);
        $checker = new Sitemap();

        $actual = $checker->check($config);

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testCheckFailure404()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/sitemap.xml')
               ->andReturn('https://example.test/sitemap.xml');

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_get')
               ->with('https://example.test/sitemap.xml')
               ->andReturn(['fake-status' => 404]);

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_retrieve_response_code')
               ->with(['fake-status' => 404])
               ->andReturn(404);

        $config = new Config([]);
        $checker = new Sitemap();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            'https://example.test/sitemap.xml returns 404'
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCheckFailureEmptyString()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/sitemap.xml')
               ->andReturn('https://example.test/sitemap.xml');

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_get')
               ->with('https://example.test/sitemap.xml')
               ->andReturn(['fake-status' => 404]);

        WP_Mock::userFunction('Itineris\Preflight\Checkers\wp_remote_retrieve_response_code')
               ->with(['fake-status' => 404])
               ->andReturn('');

        $config = new Config([]);
        $checker = new Sitemap();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            'Unable to reach https://example.test/sitemap.xml'
        );
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new Sitemap();
    }
}
