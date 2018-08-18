<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers\Trails;

use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Mockery;

trait CompiledBlacklistAwareTestTrait
{
    public function testCheckEmptyBlacklistError()
    {
        $config = Mockery::mock(
            new Config([])
        );
        $config->expects('compileBlacklist')
            ->with(Mockery::type('array'))
            ->andReturn([])
            ->once();

        $subject = $this->getSubject();

        $actual = $subject->check($config);

        $expected = ResultFactory::makeError($subject, 'Blacklist is empty.');
        $this->assertEquals($expected, $actual);
    }

    abstract protected function getSubject(): AbstractChecker;
}
