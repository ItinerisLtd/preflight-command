<?php
declare(strict_types=1);

namespace Itineris\Preflight\CLI;

use Itineris\Preflight\ResultCollection;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Disabled;
use Itineris\Preflight\Results\Error;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;
use WP_CLI;
use WP_CLI\Formatter;

class ResultCollectionPresenter
{
    private const DEFAULT_FIELDS = [
        'id',
        'status',
    ];

    public static function display(array $assocArgs, ResultCollection $resultCollection): void
    {
        // TODO: Use null coalescing assignment operator.
        $assocArgs['fields'] = $assocArgs['fields'] ?? self::DEFAULT_FIELDS;

        $formatter = new Formatter($assocArgs, $assocArgs['fields']);
        $formatter->display_items(
            self::toTable($resultCollection),
            true
        );
    }

    /**
     * Converts the underlying results into a plain PHP array which printable on console tables.
     *
     * @param ResultCollection $resultCollection The result collection instance.
     *
     * @return array
     */
    private static function toTable(ResultCollection $resultCollection): array
    {
        return array_map(function (ResultInterface $result): array {
            return self::toRow($result);
        }, $resultCollection->all());
    }

    private static function toRow(ResultInterface $result): array
    {
        $row = $result->toArray();
        $row['status'] = self::colorize($result, $row['status']);

        return $row;
    }

    private static function colorize(ResultInterface $result, string $text): string
    {
        $colors = [
            Success::class => '%G',
            Disabled::class => '%P',
            Failure::class => '%R',
            Error::class => '%1%w',
            'reset' => '%n',
        ];

        $color = $colors[get_class($result)] ?? $colors['reset'];

        return WP_CLI::colorize($color . $text . '%n');
    }
}
