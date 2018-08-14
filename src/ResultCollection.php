<?php
declare(strict_types=1);

namespace Itineris\Preflight;

class ResultCollection
{
    /**
     * Holds checker instances.
     *
     * @var ResultInterface[]
     */
    private $results = [];

    /**
     * Add a result instance to the collection.
     *
     * @param ResultInterface $result The result instance.
     *
     * @return ResultCollection
     */
    public function add(ResultInterface $result): self
    {
        $this->results[] = $result;

        return $this;
    }

    /**
     * Returns all the underlying results represented by the collection.
     *
     * @return ResultInterface[]
     */
    public function all(): array
    {
        return $this->results;
    }
}
