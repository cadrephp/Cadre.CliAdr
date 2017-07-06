<?php
namespace Cadre\CliAdr\Responder;

use Aura\Cli\Context;
use Aura\Cli\Context\Getopt;
use Aura\Cli\Status;
use Aura\Cli\Stdio;
use PHPUnit\Framework\TestCase;

class NotFoundTest extends TestCase
{
    public function testNotFound()
    {
        $getopt = $this->getMockBuilder(Getopt::class)
            ->disableOriginalConstructor()
            ->getMock();

        $getopt->method('get')
            ->willReturn('blah');

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
            ->method('errln')
            ->with($this->equalTo("Command 'blah' not found"));

        $notFound = new NotFound();

        $result = $notFound($context, $stdio);

        $this->assertSame(Status::FAILURE, $result);
    }
}
