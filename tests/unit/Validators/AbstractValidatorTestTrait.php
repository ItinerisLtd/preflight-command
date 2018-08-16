<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Validators;

use Itineris\Preflight\CheckerInterface;
use Mockery;
use WP_Mock;

trait AbstractValidatorTestTrait
{
    public function testMakeFilter()
    {
        $subjectClass = $this->getSubjectClass();

        $checker = Mockery::mock(CheckerInterface::class);
        $expected = Mockery::mock($subjectClass);

        WP_Mock::userFunction('Itineris\Preflight\Validators\apply_filters')
               ->withArgs([$subjectClass::MAKE_HOOK, Mockery::type($subjectClass), $checker, 'Hello World'])
               ->andReturn($expected)
               ->once();

        $actual = $subjectClass::make($checker, 'Hello World');

        $this->assertSame($expected, $actual);
    }

    abstract protected function getSubjectClass(): string;
}
