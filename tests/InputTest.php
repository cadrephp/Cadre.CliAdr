<?php
namespace Cadre\CliAdr;

use Aura\Cli\Context;
use Aura\Cli\Context\Getopt;
use Aura\Cli\Status;
use Aura\Cli\Stdio;

class InputTest extends \PHPUnit_Framework_TestCase
{
    public function testInput()
    {
        $getopt = $this->getMockBuilder(Getopt::class)
            ->disableOriginalConstructor()
            ->getMock();

        $getopt->method('get')
            ->willReturn(['-v' => true]);

        $context = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $context->method('getOpt')
            ->willReturn($getopt);

        $stdio = $this->createMock(Stdio::class);

        $input = new Input();

        $result = $input($context, $stdio);

        $this->assertSame([['-v' => true]], $result);
    }
}
