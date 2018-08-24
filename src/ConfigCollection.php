<?php
declare(strict_types=1);

namespace Itineris\Preflight;

class ConfigCollection
{
    public const HOOK = 'preflight_config_register';

    /**
     * The TOML converted to a PHP array.
     *
     * @var array
     */
    protected $definitions;
    /**
     * The TOML converted to Config instances.
     *
     * @var Config[]
     */
    protected $configs = [];

    /**
     * Config constructor.
     *
     * @param array $definitions The TOML converted to a PHP array.
     */
    public function __construct(array $definitions)
    {
        $this->definitions = $definitions;
    }

    /**
     * Returns a Config instance for specific checker.
     * Instantiate if necessary.
     *
     * @param string $id Id of the checker.
     *
     * @return Config
     */
    public function getConfig(string $id): Config
    {
        // TODO: Use null coalescing assignment operator.
        $this->configs[$id] = $this->configs[$id] ?? $this->registerConfig($id);

        return $this->configs[$id];
    }

    /**
     * Instantiate a Config instance for specific checker.
     *
     * @param string $id Id of the checker.
     *
     * @return Config
     */
    protected function registerConfig(string $id): Config
    {
        $definition = $this->definitions[$id] ?? [];
        $config = new Config($definition);

        return apply_filters(static::HOOK, $config, $definition, $id);
    }
}
