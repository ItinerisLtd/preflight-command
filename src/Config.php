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
     * Default blacklist plus config blacklist minus config whitelist.
     * Config whitelist has higher priority.
     *
     * @param array $defaultBlacklist The default blacklist.
     *
     * @return array
     */
    public function compileBlacklist(array $defaultBlacklist): array
    {
        return $this->mergeThenDiff(
            $defaultBlacklist,
            $this->getBlacklist(),
            $this->getWhitelist()
        );
    }

    /**
     * Merges two arrays and then excludes items from the third.
     * Implies the resulting array items are unique.
     *
     * @param array $original Items that to be added.
     * @param array $merge    Items that to be added.
     * @param array $diff     Items that to be removed.
     *
     * @return array
     */
    protected function mergeThenDiff(array $original, array $merge, array $diff): array
    {
        return array_diff(
            array_merge($original, $merge),
            $diff
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
     * Default includes plus config includes minus config excludes.
     * Config excludes has higher priority.
     *
     * @param array $defaultIncludes The default includes.
     *
     * @return array
     */
    public function compileIncludes(array $defaultIncludes): array
    {
        return $this->mergeThenDiff(
            $defaultIncludes,
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
     * Default excludes plus config excludes minus config includes.
     * Config includes has higher priority.
     *
     * @param array $defaultExcludes The default excludes.
     *
     * @return array
     */
    public function compileExcludes(array $defaultExcludes): array
    {
        return $this->mergeThenDiff(
            $defaultExcludes,
            $this->getExcludes(),
            $this->getIncludes()
        );
    }

    /**
     * Compile whitelist.
     *
     * Default whitelist plus config whitelist minus config whitelist.
     * Config blacklist has higher priority.
     *
     * @param array $defaultWhitelist The default whitelist.
     *
     * @return array
     */
    public function compileWhitelist(array $defaultWhitelist)
    {
        return $this->mergeThenDiff(
            $defaultWhitelist,
            $this->getWhitelist(),
            $this->getBlacklist()
        );
    }
}
