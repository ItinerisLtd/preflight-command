<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\ProductionHomeUrl;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use WP_Mock;

class ProductionHomeUrlTest extends Unit
{
    use AbstractCheckerTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testSuccess()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/')
               ->andReturn('https://my.production.site')
               ->once();

        $config = new Config([
            'url' => 'https://my.production.site',
        ]);
        $checker = new ProductionHomeUrl();

        $actual = $checker->check($config);

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testSuccessWithTrailingSlash()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/')
               ->andReturn('https://your.production.site/')
               ->once();

        $config = new Config([
            'url' => 'https://your.production.site/',
        ]);
        $checker = new ProductionHomeUrl();

        $actual = $checker->check($config);

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testFailure()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->with('/')
               ->andReturn('https://their.staging.site/')
               ->once();

        $config = new Config([
            'url' => 'https://their.production.site/',
        ]);
        $checker = new ProductionHomeUrl();

        $actual = $checker->check($config);

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Unexpected home URL:',
                'https://their.staging.site/',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testConfigNotSetError()
    {
        $config = new Config([]);
        $checker = new ProductionHomeUrl();

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
        return new ProductionHomeUrl();
    }
}
