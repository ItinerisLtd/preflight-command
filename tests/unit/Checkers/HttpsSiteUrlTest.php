<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\HttpsSiteUrl;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Validators\HttpsUrls;
use Mockery;
use WP_Mock;

class HttpsSiteUrlTest extends Unit
{
    use AbstractCheckerTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testUsingHttpsUrlsValidator()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\site_url')
               ->withNoArgs()
               ->andReturn('https://example.com/blog')
               ->once();

        $expected = Mockery::mock(ResultInterface::class);

        $validator = Mockery::mock(HttpsUrls::class);
        $validator->expects('validate')
                  ->with('https://example.com/blog')
                  ->andReturn($expected);

        $checker = new HttpsSiteUrl();

        WP_Mock::userFunction('Itineris\Preflight\Validators\apply_filters')
               ->with(HttpsUrls::MAKE_HOOK, Mockery::type(HttpsUrls::class), $checker, HttpsSiteUrl::FAILURE_MESSAGE)
               ->andReturn($validator)
               ->once();

        $actual = $checker->check(
            new Config([])
        );

        $this->assertSame($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new HttpsSiteUrl();
    }
}
