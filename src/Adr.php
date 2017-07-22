<?php
namespace Cadre\CliAdr;

use Aura\Cli\Context;
use Aura\Cli\Stdio;
use Arbiter\ActionHandler;

class Adr
{
    /**
     * Route map
     *
     * @var Router\Map
     *
     * @access protected
     */
    protected $map;

    /**
     * Action Factory
     *
     * @var ActionFactory
     *
     * @access protected
     */
    protected $actionFactory;

    /**
     * Handler
     *
     * @var \Arbiter\ActionHandler
     *
     * @access protected
     */
    protected $handler;

    /**
     * Aura\Cli standard input/output
     *
     * @var Stdio
     *
     * @access protected
     */
    protected $stdio;

    /**
     * __construct
     *
     * @param Router\Map    $map           Map of routes
     * @param ActionFactory $actionFactory Factory to create actions
     * @param ActionHandler $handler       Action handler
     *
     * @access public
     */
    public function __construct(
        Router\Map $map,
        ActionFactory $actionFactory,
        ActionHandler $handler
    ) {
        $this->map = $map;
        $this->actionFactory = $actionFactory;
        $this->handler = $handler;
    }

    /**
     * Get Aura\Cli standard input/output
     *
     * @return Stdio
     *
     * @access public
     */
    public function getStdio()
    {
        return $this->stdio;
    }

    /**
     * Set shared stdio instance
     *
     * @param Cli\Stdio $stdio shared stdio instance
     *
     * @return null
     *
     * @access public
     */
    protected function setStdio(Stdio $stdio)
    {
        $this->stdio = $stdio;
    }

    /**
     * Proxy to route map
     *
     * @param mixed $method called method
     * @param array $params params passed
     *
     * @return Router\Route
     *
     * @access public
     */
    public function __call($method, array $params)
    {
        return call_user_func_array([$this->map, $method], $params);
    }

    /**
     * Run Command
     *
     * @param Context $context Aura\Cli command context
     * @param Stdio   $stdio   Aura\Cli input/output
     *
     * @return mixed
     *
     * @access public
     */
    public function run(Context $context, Stdio $stdio)
    {
        $this->setStdio($stdio);
        $action = $this->actionFactory->fromContext($context);
        return $this->handler->handle($action, $context, $stdio);
    }
}
