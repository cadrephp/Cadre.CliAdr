<?php
namespace Cadre\CliAdr;

use PHPUnit\Framework\TestCase;

class BootTest extends TestCase
{
    protected $containerCache;

    protected function setUp()
    {
        $this->containerCache = __DIR__ . DIRECTORY_SEPARATOR . 'container.serialized';
        if (file_exists($this->containerCache)) {
            unlink($this->containerCache);
        }
    }

    protected function tearDown()
    {
        if (file_exists($this->containerCache)) {
            unlink($this->containerCache);
        }
    }

    public function testUncached()
    {
        $this->assertFalse(file_exists($this->containerCache));
        $boot = new Boot();
        $adr = $boot->adr();
        $this->assertInstanceOf('Cadre\CliAdr\Adr', $adr);
        $this->assertFalse(file_exists($this->containerCache));
    }

    public function testCached()
    {
        $this->assertFalse(file_exists($this->containerCache));

        // boot 'im!
        $boot = new Boot($this->containerCache);
        $adr = $boot->adr();
        $this->assertInstanceOf('Cadre\CliAdr\Adr', $adr);
        $this->assertTrue(file_exists($this->containerCache));

        // boot 'im agin, paw!
        $boot = new Boot($this->containerCache);
        $adr = $boot->adr();
        $this->assertInstanceOf('Cadre\CliAdr\Adr', $adr);
        $this->assertTrue(file_exists($this->containerCache));
    }
}
