<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Checkers\SecureSiteUrl;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Validators\AbstractValidator;
use Mockery;
use WP_Mock;

class SecureSiteUrlTest extends Unit
{
    use AbstractCheckerTestTrail;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testUsingValidator()
    {
        WP_Mock::userFunction('Itineris\Preflight\Checkers\site_url')
               ->withNoArgs()
               ->andReturn('https://example.com/blog')
               ->once();

        $expected = Mockery::mock(ResultInterface::class);

        $validator = Mockery::mock(AbstractValidator::class);
        $validator->expects('validate')
                  ->with('https://example.com/blog')
                  ->andReturn($expected);

        $checker = new SecureSiteUrl($validator);

        $actual = $checker->check(
            new Config([])
        );

        $this->assertSame($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        $validator = Mockery::mock(AbstractValidator::class);

        return new SecureSiteUrl($validator);
    }
}
