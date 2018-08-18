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
            $config->getIncludes()
        );
        $this->assertSame(
            [],
            $config->getExcludes()
        );
        $this->assertSame(
            '',
            $config->getPath()
        );
        $this->assertNull(
            $config->get('nothing')
        );
    }

    public function testCustomDefinitions()
    {
        $blacklist = ['admin', 'root'];
        $whitelist = ['alice', 'bob'];
        $includes = ['aaa', 'bbb', 'ccc'];
        $excludes = ['xxx', 'yyy', 'zzz'];
        $something = new stdClass();

        $config = new Config([
            'enabled' => false,
            'blacklist' => $blacklist,
            'whitelist' => $whitelist,
            'includes' => $includes,
            'excludes' => $excludes,
            'something' => $something,
            'path' => '/abc',
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
            $includes,
            $config->getIncludes()
        );
        $this->assertSame(
            $excludes,
            $config->getExcludes()
        );
        $this->assertSame(
            $something,
            $config->get('something')
        );
        $this->assertSame(
            '/abc',
            $config->getPath()
        );
        $this->assertNull(
            $config->get('nothing')
        );
    }

    public function testCompileBlacklist()
    {
        $config = new Config([
            'blacklist' => ['aaa', 'bbb', 'ccc'],
            'whitelist' => ['aaa', 'eee', 'xxx'],
        ]);

        $defaultBlacklist = ['aaa', 'ddd', 'eee'];

        $actual = $config->compileBlacklist($defaultBlacklist);

        sort($actual); // For assertion.
        $expected = ['bbb', 'ccc', 'ddd'];

        $this->assertSame(
            $expected,
            $actual
        );
    }

    public function testCompileWhitelist()
    {
        $config = new Config([
            'blacklist' => ['aaa', 'eee', 'xxx'],
            'whitelist' => ['aaa', 'bbb', 'ccc'],
        ]);

        $defaultWhitelist = ['aaa', 'ddd', 'eee'];

        $actual = $config->compileWhitelist($defaultWhitelist);

        sort($actual); // For assertion.
        $expected = ['bbb', 'ccc', 'ddd'];

        $this->assertSame(
            $expected,
            $actual
        );
    }

    public function testCompileIncludes()
    {
        $config = new Config([
            'includes' => ['aaa', 'bbb', 'ccc'],
            'excludes' => ['aaa', 'eee', 'xxx'],
        ]);

        $defaultIncludes = ['aaa', 'ddd', 'eee'];

        $actual = $config->compileIncludes($defaultIncludes);

        sort($actual); // For assertion.
        $expected = ['bbb', 'ccc', 'ddd'];

        $this->assertSame(
            $expected,
            $actual
        );
    }

    public function testCompileExcludes()
    {
        $config = new Config([
            'includes' => ['aaa', 'eee', 'xxx'],
            'excludes' => ['aaa', 'bbb', 'ccc'],
        ]);

        $defaultExcludes = ['aaa', 'ddd', 'eee'];

        $actual = $config->compileExcludes($defaultExcludes);

        sort($actual); // For assertion.
        $expected = ['bbb', 'ccc', 'ddd'];

        $this->assertSame(
            $expected,
            $actual
        );
    }
}
