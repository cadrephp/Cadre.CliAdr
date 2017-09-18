<?php
namespace Cadre\CliAdr\Router;

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testRouteWithoutDomain()
    {
        $router = new Map(new Route());

        $name = uniqid();

        $route = $router->route($name);

        $this->assertEquals($name, $route->name);
        $this->assertEquals('', $route->domain);
    }

    public function testRouteWithDomain()
    {
        $router = new Map(new Route());

        $name = uniqid();
        $domain = uniqid();

        $route = $router->route($name, $domain);

        $this->assertEquals($name, $route->name);
        $this->assertEquals($domain, $route->domain);
    }

    public function testRouteWithDifferentDefaultInput()
    {
        $router = new Map(new Route());

        $input = uniqid();
        $router->input($input);

        $name = uniqid();
        $domain = uniqid();

        $route = $router->route($name, $domain);

        $this->assertEquals($name, $route->name);
        $this->assertEquals($input, $route->input);
        $this->assertEquals($domain, $route->domain);
    }

    // public function testMatchRoute()
    // {
    //     $router = new Map(new Route());
    //
    //     $name = uniqid();
    //     $domain = uniqid();
    //
    //     $router->route($name, $domain);
    //
    //     $route = $router->match($name);
    //
    //     $this->assertEquals($name, $route->name);
    //     $this->assertEquals($domain, $route->domain);
    // }

    // public function testMatchRouteNotFound()
    // {
    //     $router = new Router(new Route());
    //
    //     $notFound = uniqid();
    //     $router->notFound($notFound);
    //
    //     $name = uniqid();
    //
    //     $route = $router->match($name);
    //
    //     $this->assertEquals($name, $route->name);
    //     $this->assertEquals('', $route->domain);
    //     $this->assertEquals($notFound, $route->responder);
    // }
    //
    public function testGetRoutes()
    {
        $router = new Map(new Route());

        $name = uniqid();
        $domain = uniqid();

        $route = $router->route($name, $domain);

        $routes = $router->getRoutes();
        $this->assertTrue($router->hasRoute($name));
        $this->assertFalse($router->hasRoute(md5($name)));

        $this->assertEquals($name, $routes[$name]->name);
        $this->assertEquals($domain, $routes[$name]->domain);
    }

    // public function testDefaultRouteIndex()
    // {
    //     $router = new Router(new Route());
    //
    //     $route = $router->match('');
    //
    //     $this->assertEquals('index', $route->name);
    // }
}
