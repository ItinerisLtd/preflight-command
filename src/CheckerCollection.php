<?php
declare(strict_types=1);

namespace Itineris\Preflight;

final class CheckerCollection
{
    /**
     * Holds checker instances.
     *
     * @var CheckerInterface[]
     */
    private $checkers = [];

    /**
     * Add or replace a checker instance to the collection at given id.
     *
     * @param CheckerInterface $checker The checker instance.
     *
     * @return CheckerCollection
     */
    public function set(CheckerInterface $checker): self
    {
        $this->checkers[$checker->getId()] = $checker;

        return $this;
    }

    /**
     * Returns all the underlying checkers array represented by the collection.
     *
     * @return CheckerInterface[]
     */
    public function all(): array
    {
        return $this->checkers;
    }

    /**
     * Returns the item at a given id. If the id does not exist, null is returned.
     *
     * @param string $id Id of the checker.
     *
     * @return CheckerInterface|null
     */
    public function get(string $id): ?CheckerInterface
    {
        return $this->checkers[$id] ?? null;
    }
}
