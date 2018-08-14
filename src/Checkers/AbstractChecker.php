<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\CheckerCollection;
use Itineris\Preflight\CheckerInterface;

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

    /**
     * Returns the URL to the checker document web page.
     *
     * @return string
     */
    protected function getLink(): string
    {
        return self::LINK_BASE . $this->getId() . '/';
    }

    /**
     * Returns the description of the checker.
     *
     * @return string
     */
    protected function getDescription(): string
    {
        return static::DESCRIPTION;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return static::ID;
    }

    /**
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
}
