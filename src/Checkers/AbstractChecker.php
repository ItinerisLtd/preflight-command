<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\CheckerCollection;
use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Error;

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
            new static()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return static::ID;
    }

    /**
     * Returns the URL to the checker document web page.
     *
     * @return string
     */
    public function getLink(): string
    {
        return static::LINK_BASE . $this->getId() . '.html';
    }

    /**
     * Returns the description of the checker.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return static::DESCRIPTION;
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
            return ResultFactory::makeDisabled($this);
        }

        $error = $this->maybeInvalidConfig($config);
        if (null !== $error) {
            return $error;
        }

        // TODO: Wrap it with try catch block.
        return $this->run($config);
    }

    /**
     * Run the check and return a result.
     *
     * Assume the checker is enabled and its config make sense.
     *
     * @param Config $config The config instance.
     *
     * @return ResultInterface
     */
    abstract protected function run(Config $config): ResultInterface;

    /**
     * Before actually run the check, check the config is valid.
     *
     * @param Config $config The config instance.
     *
     * @return Error|null
     */
    protected function maybeInvalidConfig(Config $config): ?Error
    {
        return null;
    }
}
