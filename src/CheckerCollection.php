<?php
declare(strict_types=1);

namespace Itineris\Preflight;

class CheckerCollection
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

    /**
     * Converts the underlying collection into a plain PHP array.
     *
     * TODO: Maybe move into CLI namespace?
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function (CheckerInterface $checker): array {
            return $checker->toArray();
        }, $this->all());
    }

    /**
     * Returns all the underlying checkers represented by the collection.
     *
     * @return CheckerInterface[]
     */
    public function all(): array
    {
        return $this->checkers;
    }

    /**
     * Returns all checker ids.
     *
     * TODO: Maybe move into CLI namespace?
     *
     * @return string[]
     */
    public function pluckIds(): array
    {
        return array_keys(
            $this->all()
        );
    }
}
