<?php
namespace Cadre\CliAdr\Router;

class Map
{
    /**
     * Route prototype
     *
     * @var Route
     *
     * @access protected
     */
    protected $protoRoute;

    /**
     * Routes
     *
     * @var array
     *
     * @access protected
     */
    protected $routes = [];

    /**
     * __construct
     *
     * @param Route $protoRoute prototype for route
     *
     * @access public
     */
    public function __construct(Route $protoRoute)
    {
        $this->protoRoute = $protoRoute;
    }

    /**
     * Proxy calls to protoroute
     *
     * @param mixed $method method called
     * @param mixed $params params passed
     *
     * @return $this
     *
     * @access public
     */
    public function __call($method, $params)
    {
        call_user_func_array([$this->protoRoute, $method], $params);
        return $this;
    }

    /**
     * Replace all routes
     *
     * @param array $routes routes to replace
     *
     * @return null
     *
     * @access public
     */
    public function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Get all routes
     *
     * @return array
     *
     * @access public
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Set a route
     *
     * @param string $name   name of command
     * @param mixed  $domain command domain spec
     *
     * @return Route
     *
     * @access public
     */
    public function route($name, $domain = null)
    {
        $this->routes[$name] = clone $this->protoRoute;
        $this->routes[$name]->name($name);
        if (isset($domain)) {
            $this->routes[$name]->domain($domain);
        }
        return $this->routes[$name];
    }

    /**
     * Get a route by name
     *
     * @param mixed $name name of route
     *
     * @return Route
     * @throws \Exception if route does not exist
     *
     * @access public
     */
    public function getRoute($name)
    {
        if (! $this->hasRoute($name)) {
            throw new \Exception($name);
        }
        return $this->routes[$name];
    }

    /**
     * Is there a route by this name?
     *
     * @param string $name name of route
     *
     * @return bool
     *
     * @access public
     */
    public function hasRoute($name)
    {
        return isset($this->routes[$name]);
    }
}
