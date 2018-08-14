<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\CheckerCollection;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Disabled;
use Itineris\Preflight\Results\Error;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Skip;
use Itineris\Preflight\Results\Success;

abstract class AbstractChecker implements CheckerInterface
{
    public const ID = self::ID;
    public const DESCRIPTION = self::DESCRIPTION;
    public const LINK_BASE = 'https://itinerisltd.github.io/preflight-command/checkers/';

    /**
     * Register an instance to the checkerCollection during CheckerCollectionFactory::REGISTER_HOOK.
     *
     * @param CheckerCollection $checkerCollection The CheckerCollection instance.
     */
    public static function register(CheckerCollection $checkerCollection): void
    {
        $checkerCollection->set(
            static::make()
        );
    }

    /**
     * Returns an instance of this class.
     *
     * @return AbstractChecker
     */
    protected static function make(): self
    {
        return new static();
    }

    protected function makeSuccess(?string $message = null): Success
    {
        return new Success($this, $message);
    }    /**
     * Returns the URL to the checker document web page.
     *
     * @return string
     */
    protected function getLink(): string
    {
        return self::LINK_BASE . $this->getId() . '/';
    }

    protected function makeFailure(?string $message = null): Failure
    {
        return new Failure($this, $message);
    }    /**
     * Returns the description of the checker.
     *
     * @return string
     */
    protected function getDescription(): string
    {
        return static::DESCRIPTION;
    }

    protected function makeSkip(?string $message = null): Skip
    {
        return new Skip($this, $message);
    }    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return static::ID;
    }

    protected function makeError(?string $message = null): Error
    {
        return new Error($this, $message);
    }    /**
     * Converts the checker into a plain PHP array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'link' => $this->getLink(),
            'description' => $this->getDescription(),
        ];
    }

    /**
     * Run the check and return a result.
     *
     * @param Config $config The config instance.
     *
     * @return ResultInterface
     */
    public function check(Config $config): ResultInterface
    {
        if (! $config->isEnabled()) {
            return new Disabled($this);
        }

        $skip = $this->maybeSkip($config);
        if (null !== $skip) {
            return $skip;
        }

        $error = $this->maybeError($config);
        if (null !== $error) {
            return $error;
        }

        // TODO: Wrap it with try catch block.
        return $this->run($config);
    }

    /**
     * Run the check and return a result.
     *
     * Assume the checker is enabled and should not be skipped.
     *
     * @param Config $config The config instance.
     *
     * @return ResultInterface
     */
    abstract protected function run(Config $config): ResultInterface;









    /**
     * Whether this checker should be skipped according to the config.
     *
     * Assume $config->isEnabled() is true.
     *
     * @param Config $config The config instance.
     *
     * @return Skip|null
     */
    protected function maybeSkip(Config $config): ?Skip
    {
        return null;
    }

    /**
     * Before actually run the check, whether this checker should throw error according to the config.
     *
     * @param Config $config The config instance.
     *
     * @return Error|null
     */
    protected function maybeError(Config $config): ?Error
    {
        return null;
    }
}
