<?php
declare(strict_types=1);

namespace Itineris\Preflight;

class Config
{
    protected const DEFAULT_DEFINITIONS = [
        'enabled' => true,
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
        return (bool) $this->get('enabled');
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
     * Compile blacklist.
     *
     * Blacklist minus whitelist.
     *
     * @return array
     */
    public function compileBlacklist(): array
    {
        return array_diff(
            $this->getBlacklist(),
            $this->getWhitelist()
        );
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
     * Whitelist getter.
     *
     * @return array
     */
    public function getWhitelist(): array
    {
        return (array) $this->get('whitelist') ?? [];
    }

    /**
     * Path getter.
     *
     * @return string
     */
    public function getPath(): string
    {
        return (string) $this->get('path') ?? '';
    }

    /**
     * Compile includes.
     *
     * Includes minus excludes.
     *
     * @return array
     */
    public function compileIncludes(): array
    {
        return array_diff(
            $this->getIncludes(),
            $this->getExcludes()
        );
    }

    /**
     * Includes getter.
     *
     * @return array
     */
    public function getIncludes(): array
    {
        return (array) $this->get('includes') ?? [];
    }

    /**
     * Excludes getter.
     *
     * @return array
     */
    public function getExcludes(): array
    {
        return (array) $this->get('excludes') ?? [];
    }

    /**
     * Compile excludes.
     *
     * Excludes minus includes.
     *
     * @return array
     */
    public function compileExcludes(): array
    {
        return array_diff(
            $this->getExcludes(),
            $this->getIncludes()
        );
    }

    /**
     * Compile whitelist.
     *
     * Whitelist minus blacklist.
     *
     * @return array
     */
    public function compileWhitelist(): array
    {
        return array_diff(
            $this->getWhitelist(),
            $this->getBlacklist()
        );
    }
}
