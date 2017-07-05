<?php
namespace Cadre\CliAdr;

use Aura\Di\Injection\InjectionFactory;
use PHPUnit\Framework\TestCase;

class ResolverTest extends TestCase
{
    public function testInvokeResolver()
    {
        $value = uniqid();

        $injectionFactory = $this->getMockBuilder(InjectionFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $injectionFactory
            ->expects($this->once())
            ->method('newInstance')
            ->will($this->returnValue($value));

        $resolver = new Resolver($injectionFactory);

        $result = $resolver('ClassName');

        $this->assertEquals($value, $result);
    }

    public function testInvokeArrayResolver()
    {
        $value = uniqid();

        $injectionFactory = $this->getMockBuilder(InjectionFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $injectionFactory
            ->expects($this->once())
            ->method('newInstance')
            ->will($this->returnValue($value));

        $resolver = new Resolver($injectionFactory);

        $result = $resolver(['ClassName', 'MethodName']);

        $this->assertEquals($value, $result[0]);
    }
}
