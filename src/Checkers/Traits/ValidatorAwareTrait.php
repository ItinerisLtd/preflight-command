<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers\Traits;

use Itineris\Preflight\Validators\AbstractValidator;

trait ValidatorAwareTrait
{
    /**
     * The validator instance.
     *
     * @var AbstractValidator
     */
    protected $validator;

    /**
     * ValidatorAwareTrait constructor.
     *
     * @param AbstractValidator $validator The validator instance.
     */
    public function __construct(?AbstractValidator $validator = null)
    {
        $this->validator = $validator ?? $this->makeDefaultValidator();
    }

    /**
     * Returns a default validator instance.
     *
     * Used by the constructor.
     *
     * @return AbstractValidator
     */
    abstract protected function makeDefaultValidator(): AbstractValidator;
}
