<?php
declare(strict_types=1);

namespace Itineris\Preflight\CLI;

use Itineris\Preflight\CheckerCollection;
use Itineris\Preflight\CheckerInterface;
use WP_CLI\Formatter;

class CheckerCollectionPresenter
{
    private const DEFAULT_FIELDS = [
        'id',
        'description',
        'link',
    ];

    /**
     * Display a checker collection in a given format.
     *
     * @param array             $assocArgs         Associative CLI argument.
     * @param CheckerCollection $checkerCollection The checker collection instance.
     */
    public static function display(array $assocArgs, CheckerCollection $checkerCollection): void
    {
        // TODO: Use null coalescing assignment operator.
        $assocArgs['fields'] = $assocArgs['fields'] ?? self::DEFAULT_FIELDS;
        $formatter = new Formatter($assocArgs, $assocArgs['fields']);

        $items = (in_array($formatter->format, ['ids', 'count'], true))
            ? self::pluckIds($checkerCollection)
            : self::toArray($checkerCollection);

        $formatter->display_items($items);
    }

    /**
     * Returns all checker ids.
     *
     * @param CheckerCollection $checkerCollection The checker collection instance.
     *
     * @return string[]
     */
    public static function pluckIds(CheckerCollection $checkerCollection): array
    {
        return array_keys(
            $checkerCollection->all()
        );
    }

    /**
     * Converts the underlying checkers into a plain PHP array.
     *
     * @param CheckerCollection $checkerCollection The checker collection instance.
     *
     * @return array
     */
    private static function toArray(CheckerCollection $checkerCollection): array
    {
        return array_map(function (CheckerInterface $checker): array {
            return [
                'id' => $checker->getId(),
                'description' => $checker->getDescription(),
                'link' => $checker->getLink(),
            ];
        }, $checkerCollection->all());
    }
}
