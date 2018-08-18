<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test\Validators;

use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\Results\Success;
use Itineris\Preflight\Validators\AbstractValidator;
use Mockery;

trait AbstractValidatorTestTrait
{
    public function testReportSuccess()
    {
        $checker = Mockery::mock(CheckerInterface::class);

        $subject = $this->getSubject($checker, 'You shall not pass!');

        $actual = $subject->report();

        $this->assertInstanceOf(Success::class, $actual);
    }

    public function testReportFailureMessage()
    {
        $checker = Mockery::mock(CheckerInterface::class);

        $subject = $this->getSubject($checker, 'You shall not pass!');

        $result = $subject->report('I am a servant of the Secret Fire, wielder of the flame of Anor.');

        $actual = $result->getMessages();

        $this->assertSame([
            'You shall not pass!',
            'I am a servant of the Secret Fire, wielder of the flame of Anor.',
        ], $actual);
    }

    public function testReportMultipleFailureMessages()
    {
        $checker = Mockery::mock(CheckerInterface::class);

        $subject = $this->getSubject($checker, 'You shall not pass!');

        $result = $subject->report(
            'I am a servant of the Secret Fire, wielder of the flame of Anor.',
            'You cannot pass.'
        );

        $actual = $result->getMessages();

        $this->assertSame([
            'You shall not pass!',
            'I am a servant of the Secret Fire, wielder of the flame of Anor.',
            'You cannot pass.',
        ], $actual);
    }

    abstract protected function getSubject(CheckerInterface $checker, string $message): AbstractValidator;
}
