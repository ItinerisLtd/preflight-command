<?php
declare(strict_types=1);

namespace Itineris\Preflight;

class Config
{
    protected const DEFAULT_DEFINITIONS = [
        'enabled' => true,
        'blacklist' => [],
        'whitelist' => [],
        'requirements' => [],
    ];

    /**
     * Holds the raw config definitions.
     *
     * @var array
     */
    protected $definitions;

    /**
     * CheckerConfig constructor.
     *
     * @param array $definitions The config definition.
     */
    public function __construct(array $definitions)
    {
        $this->definitions = array_merge(static::DEFAULT_DEFINITIONS, $definitions);
    }

    /**
     * Enable getter.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (bool) $this->get('enabled') ?? true;
    }

    /**
     * Getter a specific config.
     *
     * @param string $key Key of the config.
     *
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->definitions[$key] ?? null;
    }

    /**
     * Whitelist getter.
     *
     * @return array
     */
    public function getWhitelist(): array
    {
        return (array) $this->get('whitelist') ?? [];
    }

    /**
     * Blacklist getter.
     *
     * @return array
     */
    public function getBlacklist(): array
    {
        return (array) $this->get('blacklist') ?? [];
    }

    /**
     * Requirements getter.
     *
     * @return array
     */
    public function getRequirements(): array
    {
        return (array) $this->get('requirements') ?? [];
    }
}
