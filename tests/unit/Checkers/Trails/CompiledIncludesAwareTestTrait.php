<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Checkers\Trails;

use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;

trait CompiledIncludesAwareTestTrait
{
    public function testCheckEmptyIncludesError()
    {
        $subject = $this->getSubject();

        $config = new Config([
            'whitelist' => $subject::DEFAULT_INCLUDES,
        ]);

        $actual = $subject->check($config);

        $expected = ResultFactory::makeError($subject, 'Includes is empty.');
        $this->assertEquals($expected, $actual);
    }

    abstract protected function getSubject(): AbstractChecker;
}
