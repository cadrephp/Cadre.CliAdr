<?php
namespace Cadre\CliAdr;

use Aura\Di\ContainerBuilder;
use Aura\Cli\Context;
use Aura\Cli\Context\Getopt;
use Aura\Cli\Status;
use Aura\Cli\Stdio;

class AdrTest extends \PHPUnit\Framework\TestCase
{
    public function testAdr()
    {
        $di = (new ContainerBuilder())
            ->newConfiguredInstance([
                'Cadre\CliAdr\Config',
            ]);

        $adr = $di->get('cadre:cliadr/adr');

        $getopt = $this->getMockBuilder(Getopt::class)
            ->disableOriginalConstructor()
            ->getMock();

        $getopt->method('get')
            ->willReturn('test');

        $context = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $context->method('getOpt')
            ->willReturn($getopt);

        $stdio = $this->getMockBuilder(Stdio::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stdio
            ->expects($this->once())
            ->method('outln')
            ->with($this->equalTo("This is a test."));

        $adr->route('test', function ($params) {
            return 'This is a test.';
        });

        $result = $adr->run($context, $stdio);

        $this->assertEquals(Status::SUCCESS, $result);
    }

    public function testMissingResponder()
    {
        $this->expectException('Exception');

        $di = (new ContainerBuilder())
            ->newConfiguredInstance([
                'Cadre\CliAdr\Config',
            ]);

        $adr = $di->get('cadre:cliadr/adr');

        $getopt = $this->getMockBuilder(Getopt::class)
            ->disableOriginalConstructor()
            ->getMock();

        $getopt->method('get')
            ->willReturn('test');

        $context = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $context->method('getOpt')
            ->willReturn($getopt);

        $stdio = $this->getMockBuilder(Stdio::class)
            ->disableOriginalConstructor()
            ->getMock();

        $adr->responder(false);

        $adr->route('test', function ($params) {
            return 'This is a test.';
        });

        $result = $adr->run($context, $stdio);
    }

    public function testBadResponder()
    {
        $this->expectException('ReflectionException');

        $di = (new ContainerBuilder())
            ->newConfiguredInstance([
                'Cadre\CliAdr\Config',
            ]);

        $adr = $di->get('cadre:cliadr/adr');

        $getopt = $this->getMockBuilder(Getopt::class)
            ->disableOriginalConstructor()
            ->getMock();

        $getopt->method('get')
            ->willReturn('test');

        $context = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $context->method('getOpt')
            ->willReturn($getopt);

        $stdio = $this->getMockBuilder(Stdio::class)
            ->disableOriginalConstructor()
            ->getMock();

        $adr->route('test', function ($params) {
            return 'This is a test.';
        })
        ->responder('BadNews');

        $result = $adr->run($context, $stdio);
    }

    public function testNotFound()
    {
        $di = (new ContainerBuilder())
            ->newConfiguredInstance([
                'Cadre\CliAdr\Config',
            ]);

        $adr = $di->get('cadre:cliadr/adr');

        $getopt = $this->getMockBuilder(Getopt::class)
            ->disableOriginalConstructor()
            ->getMock();

        $getopt->method('get')
            ->willReturn('test');

        $context = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $context->method('getOpt')
            ->willReturn($getopt);

        $stdio = $this->getMockBuilder(Stdio::class)
            ->disableOriginalConstructor()
            ->getMock();

        $result = $adr->run($context, $stdio);

        $this->assertEquals(Status::FAILURE, $result);
    }
}
