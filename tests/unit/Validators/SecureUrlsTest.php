<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Validators;

use Codeception\Test\Unit;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use Itineris\Preflight\Validators\AbstractValidator;
use Itineris\Preflight\Validators\SecureUrls;
use Mockery;
use WP_Mock;

class SecureUrlsTest extends Unit
{
    use AbstractValidatorTestTrait;

    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testSuccess()
    {
        WP_Mock::userFunction('Itineris\Preflight\Validators\wp_parse_url')
               ->with('https://example.com/blog', PHP_URL_SCHEME)
               ->andReturn('https')
               ->once();

        $checker = Mockery::mock(CheckerInterface::class);
        $validator = new SecureUrls($checker);

        $actual = $validator->validate('https://example.com/blog');

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testFailure()
    {
        WP_Mock::userFunction('Itineris\Preflight\Validators\wp_parse_url')
               ->with('http://example.com/blog', PHP_URL_SCHEME)
               ->andReturn('http')
               ->once();

        $checker = Mockery::mock(CheckerInterface::class);
        $validator = new SecureUrls($checker);

        $actual = $validator->validate('http://example.com/blog');

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'URLs are insecure (non-HTTPS):',
                'http://example.com/blog',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCustomFailureMessage()
    {
        WP_Mock::userFunction('Itineris\Preflight\Validators\wp_parse_url')
               ->with('http://example.com/blog', PHP_URL_SCHEME)
               ->andReturn('http')
               ->once();

        $checker = Mockery::mock(CheckerInterface::class);
        $validator = new SecureUrls($checker, 'Doing it wrong');

        $actual = $validator->validate('http://example.com/blog');

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'Doing it wrong',
                'http://example.com/blog',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testNull()
    {
        WP_Mock::userFunction('Itineris\Preflight\Validators\wp_parse_url')
               ->with('boom!', PHP_URL_SCHEME)
               ->andReturnNull()
               ->once();

        $checker = Mockery::mock(CheckerInterface::class);
        $validator = new SecureUrls($checker);

        $actual = $validator->validate('boom!');

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'URLs are insecure (non-HTTPS):',
                'boom!',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testFalse()
    {
        WP_Mock::userFunction('Itineris\Preflight\Validators\wp_parse_url')
               ->with('boom://', PHP_URL_SCHEME)
               ->andReturnFalse()
               ->once();

        $checker = Mockery::mock(CheckerInterface::class);
        $validator = new SecureUrls($checker);

        $actual = $validator->validate('boom://');

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'URLs are insecure (non-HTTPS):',
                'boom://',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testMultipleFailure()
    {
        WP_Mock::userFunction('Itineris\Preflight\Validators\wp_parse_url')
               ->with('http://example.com', PHP_URL_SCHEME)
               ->andReturn('http')
               ->once();
        WP_Mock::userFunction('Itineris\Preflight\Validators\wp_parse_url')
               ->with('https://example.com/blog', PHP_URL_SCHEME)
               ->andReturn('https')
               ->once();
        WP_Mock::userFunction('Itineris\Preflight\Validators\wp_parse_url')
               ->with('boom://', PHP_URL_SCHEME)
               ->andReturnFalse()
               ->once();

        $checker = Mockery::mock(CheckerInterface::class);
        $validator = new SecureUrls($checker);

        $actual = $validator->validate(
            'http://example.com',
            'https://example.com/blog',
            'boom://'
        );

        $expected = ResultFactory::makeFailure(
            $checker,
            [
                'URLs are insecure (non-HTTPS):',
                'http://example.com',
                'boom://',
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(CheckerInterface $checker, string $message): AbstractValidator
    {
        return new SecureUrls($checker, $message);
    }
}
