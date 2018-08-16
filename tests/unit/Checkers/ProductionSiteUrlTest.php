<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\ProductionSiteUrl;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use WP_Mock;

class ProductionSiteUrlTest extends Unit
{
    use AbstractCheckerTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testSuccess()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\site_url')
               ->with('/')
               ->andReturn('https://my.production.site/blog')
               ->once();

        $config = new Config([
            'url' => 'https://my.production.site/blog',
        ]);
        $checker = new ProductionSiteUrl();

        $actual = $checker->check($config);

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testSuccessWithTrailingSlash()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\site_url')
               ->with('/')
               ->andReturn('https://your.production.site/blog')
               ->once();

        $config = new Config([
            'url' => 'https://your.production.site/blog',
        ]);
        $checker = new ProductionSiteUrl();

        $actual = $checker->check($config);

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testFailure()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\site_url')
               ->with('/')
               ->andReturn('https://their.staging.site/blog')
               ->once();

        $config = new Config([
            'url' => 'https://their.production.site/blog',
        ]);
        $checker = new ProductionSiteUrl();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Unexpected site URL:',
                'https://their.staging.site/blog',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testConfigNotSetError()
    {
        $config = new Config([]);
        $checker = new ProductionSiteUrl();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeError(
            $checker,
            [
                'Expected URL not defined in preflight.toml.',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new ProductionSiteUrl();
    }
}
