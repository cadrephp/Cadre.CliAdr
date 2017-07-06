<?php
namespace Cadre\CliAdr\Responder;

use Aura\Cli\Context;
use Aura\Cli\Status;
use Aura\Cli\Stdio;
use PHPUnit\Framework\TestCase;

class ResponderTest extends TestCase
{
    public function testResponderWithNoPayload()
    {
        $context = $this->createMock(Context::class);
        $stdio = $this->getMockBuilder(Stdio::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stdio
            ->expects($this->never())
            ->method('outln');

        $responder = new Responder();

        $result = $responder($context, $stdio);

        $this->assertSame(Status::SUCCESS, $result);
    }

    public function testResponderWithArrayPayload()
    {
        $context = $this->createMock(Context::class);
        $stdio = $this->getMockBuilder(Stdio::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stdio
            ->expects($this->exactly(2))
            ->method('outln');

        $responder = new Responder();

        $result = $responder($context, $stdio, ['a', 'b']);

        $this->assertSame(Status::SUCCESS, $result);
    }

    public function testResponderWithDeepArrayPayload()
    {
        $context = $this->createMock(Context::class);
        $stdio = $this->getMockBuilder(Stdio::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stdio
            ->expects($this->exactly(1))
            ->method('outln')
            ->with($this->equalTo("Array ( [0] => deep )"));

        $responder = new Responder();

        $result = $responder($context, $stdio, [['deep']]);

        $this->assertSame(Status::SUCCESS, $result);
    }

    public function testResponderWithStringPayload()
    {
        $context = $this->createMock(Context::class);
        $stdio = $this->getMockBuilder(Stdio::class)
            ->disableOriginalConstructor()
            ->getMock();

        $line = uniqid();

        $stdio
            ->expects($this->exactly(1))
            ->method('outln')
            ->with($this->equalTo($line));

        $responder = new Responder();

        $result = $responder($context, $stdio, $line);

        $this->assertSame(Status::SUCCESS, $result);
    }
}
