<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Checkers\Traits\CompiledIncludesAwareTrait;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Error;

class UniqueSaltConstants extends AbstractChecker
{
    use CompiledIncludesAwareTrait;

    public const ID = 'unique-salt-constants';
    public const DESCRIPTION = 'Ensure each salt constant is unique.';

    /**
     * {@inheritdoc}
     *
     * @param Config $config The config instance.
     *
     * @return ResultInterface
     */
    protected function run(Config $config): ResultInterface
    {
        $includes = $config->compileIncludes();

        $constants = [];
        foreach ($includes as $key) {
            // phpcs:ignore WordPressVIPMinimum.Constants.ConstantString.NotCheckingConstantName
            $constants[$key] = defined($key)
                ? (string) constant($key)
                : '';
        }

        $duplicatedValues = array_values(
            array_diff_assoc(
                $constants,
                array_unique($constants)
            )
        );

        $duplicated = array_keys(
            array_filter($constants, function (string $value) use ($duplicatedValues): bool {
                return in_array($value, $duplicatedValues, true);
            })
        );

        if (! empty($duplicated)) {
            $messages = array_merge(['Salt constants are not unique(or not defined):'], $duplicated);

            return ResultFactory::makeFailure($this, $messages);
        }

        return ResultFactory::makeSuccess($this);
    }

    /**
     * {@inheritdoc}
     *
     * @param Config $config The config instance.
     *
     * @return Error|null
     */
    protected function maybeInvalidConfig(Config $config): ?Error
    {
        return $this->errorIfCompiledIncludesIsEmpty($config);
    }
}
