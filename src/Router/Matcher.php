<?php
namespace Cadre\CliAdr\Router;

use Aura\Cli\Context;

class Matcher
{
    /**
     * Route Map
     *
     * @var Map
     *
     * @access protected
     */
    protected $map;

    /**
     * Default route name
     *
     * @var string
     *
     * @access protected
     */
    protected $default;

    /**
     * __construct
     *
     * @param Router\Map $map     map of routes to names
     * @param string     $default default route name
     *
     * @access public
     */
    public function __construct(Map $map, $default = 'index')
    {
        $this->map     = $map;
        $this->default = $default;
    }

    /**
     * Get a route based on command context
     *
     * @param Context $context Command context
     *
     * @return Route|false
     *
     * @access public
     */
    public function match(Context $context)
    {
        $name = $this->getName($context);

        if ($this->map->hasRoute($name)) {
            return $this->map->getRoute($name);
        }

        return false;
    }

    /**
     * Get command name from Context
     *
     * @param Context $context Command Context
     *
     * @return string
     *
     * @access protected
     */
    public function getName(Context $context)
    {
        return $context->getopt([])->get(1, $this->default);
    }
}
