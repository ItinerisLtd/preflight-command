<?php
declare(strict_types=1);

namespace Itineris\Preflight\Test;

use Itineris\Preflight\Config;
use stdClass;

class ConfigTest extends \Codeception\Test\Unit
{
    /**
     * @var \Itineris\Preflight\Test\UnitTester
     */
    protected $tester;

    public function testDefaultDefinitions()
    {
        $config = new Config([]);

        $this->assertTrue(
            $config->isEnabled()
        );
        $this->assertSame(
            [],
            $config->getBlacklist()
        );
        $this->assertSame(
            [],
            $config->getWhitelist()
        );
        $this->assertSame(
            [],
            $config->getRequirements()
        );
        $this->assertNull(
            $config->get('nothing')
        );
    }

    /**
     *
     */
    public function testCustomDefinitions()
    {
        $blacklist = ['admin', 'root'];
        $whitelist = ['alice', 'bob'];
        $requirements = ['xxx', 'yyy', 'zzz'];
        $something = new stdClass();

        $config = new Config([
            'enabled' => false,
            'blacklist' => $blacklist,
            'whitelist' => $whitelist,
            'requirements' => $requirements,
            'something' => $something,
        ]);

        $this->assertFalse(
            $config->isEnabled()
        );
        $this->assertSame(
            $blacklist,
            $config->getBlacklist()
        );
        $this->assertSame(
            $whitelist,
            $config->getWhitelist()
        );
        $this->assertSame(
            $requirements,
            $config->getRequirements()
        );
        $this->assertSame(
            $something,
            $config->get('something')
        );
        $this->assertNull(
            $config->get('nothing')
        );
    }
}
