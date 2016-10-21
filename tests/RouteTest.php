<?php
namespace Cadre\CliAdr;

class RouteTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultRoute()
    {
        $route = new Route();

        $this->assertEquals('', $route->name);
        $this->assertEquals('Cadre\CliAdr\Input', $route->input);
        $this->assertEquals('', $route->domain);
        $this->assertEquals('Cadre\CliAdr\Responder', $route->responder);
    }

    public function testCustomName()
    {
        $name = uniqid();
        $route = (new Route())->name($name);

        $this->assertEquals($name, $route->name);
    }

    public function testCustomInput()
    {
        $input = uniqid();
        $route = (new Route())->input($input);

        $this->assertEquals($input, $route->input);
    }

    public function testCustomDomain()
    {
        $domain = uniqid();
        $route = (new Route())->domain($domain);

        $this->assertEquals($domain, $route->domain);
    }

    public function testCustomResponder()
    {
        $responder = uniqid();
        $route = (new Route())->responder($responder);

        $this->assertEquals($responder, $route->responder);
    }
}
