<?php
namespace Cadre\CliAdr\Input;

use Aura\Cli\Context;
use Aura\Cli\Context\Getopt;
use Aura\Cli\Help as AuraCliHelp;
use Aura\Cli\Status;
use Aura\Cli\Stdio;
use PHPUnit\Framework\TestCase;

class HelpTest extends TestCase
{
    public function testInvoke()
    {
        $name = uniqid();

        $getopt = $this->getMockBuilder(Getopt::class)
            ->disableOriginalConstructor()
            ->getMock();

        $getopt->method('get')
            ->with($this->equalTo(2))
            ->willReturn($name);

        $context = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $context->method('getOpt')
            ->willReturn($getopt);

        $stdio = $this->createMock(Stdio::class);

        $input = new Help();

        $result = $input($context, $stdio);

        $this->assertSame([$name], $result);
    }

    public function testHelp()
    {
        $name = uniqid();

        $help = $this->getMockBuilder(AuraCliHelp::class)
            ->disableOriginalConstructor()
            ->getMock();

        $help->expects($this->once())
            ->method('setSummary')
            ->with('Display this help message');

        $help->expects($this->once())
            ->method('setOptions')
            ->with(['#command?' => 'The command name [default: "help"]']);

        $input = new Help();

        $input->help($help);
    }
}
