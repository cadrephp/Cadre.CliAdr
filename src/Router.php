<?php
namespace Cadre\CliAdr;

class Router
{
    protected $protoRoute;
    protected $routes = [];
    protected $notFound = 'Cadre\CliAdr\NotFound';

    public function __construct(Route $protoRoute)
    {
        $this->protoRoute = $protoRoute;
    }

    public function __call($method, $params)
    {
        call_user_func_array([$this->protoRoute, $method], $params);
        return $this;
    }

    public function notFound($responder)
    {
        $this->notFound = $responder;
    }

    public function route($name, $domain = null)
    {
        $this->routes[$name] = clone $this->protoRoute;
        $this->routes[$name]->name($name);
        if (isset($domain)) {
            $this->routes[$name]->domain($domain);
        }
        return $this->routes[$name];
    }

    public function match($name)
    {
        if (isset($this->routes[$name])) {
            return $this->routes[$name];
        }

        return $this->route($name)
            ->responder($this->notFound);
    }
}
