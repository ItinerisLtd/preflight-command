<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\HttpsHomeUrl;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Validators\HttpsUrls;
use Mockery;
use WP_Mock;

class HttpsHomeUrlTest extends Unit
{
    use AbstractCheckerTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testUsingHttpsUrlsValidator()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\home_url')
               ->withNoArgs()
               ->andReturn('https://example.com')
               ->once();

        $expected = Mockery::mock(ResultInterface::class);

        $validator = Mockery::mock(HttpsUrls::class);
        $validator->expects('validate')
                  ->with('https://example.com')
                  ->andReturn($expected);

        $checker = new HttpsHomeUrl();

        WP_Mock::userFunction('Itineris\Preflight\Validators\apply_filters')
               ->with(HttpsUrls::MAKE_HOOK, Mockery::type(HttpsUrls::class), $checker, HttpsHomeUrl::FAILURE_MESSAGE)
               ->andReturn($validator)
               ->once();

        $actual = $checker->check(
            new Config([])
        );

        $this->assertSame($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new HttpsHomeUrl();
    }
}
