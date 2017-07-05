<?php
namespace Cadre\CliAdr;

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testRouteWithoutDomain()
    {
        $router = new Router(new Route());

        $name = uniqid();

        $route = $router->route($name);

        $this->assertEquals($name, $route->name);
        $this->assertEquals('', $route->domain);
    }

    public function testRouteWithDomain()
    {
        $router = new Router(new Route());

        $name = uniqid();
        $domain = uniqid();

        $route = $router->route($name, $domain);

        $this->assertEquals($name, $route->name);
        $this->assertEquals($domain, $route->domain);
    }

    public function testRouteWithDifferentDefaultInput()
    {
        $router = new Router(new Route());

        $input = uniqid();
        $router->input($input);

        $name = uniqid();
        $domain = uniqid();

        $route = $router->route($name, $domain);

        $this->assertEquals($name, $route->name);
        $this->assertEquals($input, $route->input);
        $this->assertEquals($domain, $route->domain);
    }

    public function testMatchRoute()
    {
        $router = new Router(new Route());

        $name = uniqid();
        $domain = uniqid();

        $router->route($name, $domain);

        $route = $router->match($name);

        $this->assertEquals($name, $route->name);
        $this->assertEquals($domain, $route->domain);
    }

    public function testMatchRouteNotFound()
    {
        $router = new Router(new Route());

        $notFound = uniqid();
        $router->notFound($notFound);

        $name = uniqid();

        $route = $router->match($name);

        $this->assertEquals($name, $route->name);
        $this->assertEquals('', $route->domain);
        $this->assertEquals($notFound, $route->responder);
    }
}
