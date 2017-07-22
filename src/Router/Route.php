<?php
namespace Cadre\CliAdr\Router;

use Cadre\CliAdr\Responder\Responder;
use Cadre\CliAdr\Input\Input;

class Route
{
    /**
     * Name of command
     *
     * @var mixed
     *
     * @access protected
     */
    protected $name;

    /**
     * Input extractor
     *
     * @var mixed
     *
     * @access protected
     */
    protected $input = Input::class;

    /**
     * Command domain
     *
     * @var mixed
     *
     * @access protected
     */
    protected $domain;

    /**
     * Command responder
     *
     * @var mixed
     *
     * @access protected
     */
    protected $responder = Responder::class;

    /**
     * Proxy to protected properties
     *
     * @param string $key name of property
     *
     * @return mixed
     *
     * @access public
     */
    public function __get($key)
    {
        return $this->$key;
    }

    /**
     * Set route name
     *
     * @param string $name name of command
     *
     * @return $this
     *
     * @access public
     */
    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set input spec
     *
     * @param mixed $input input specification
     *
     * @return $this
     *
     * @access public
     */
    public function input($input)
    {
        $this->input = $input;
        return $this;
    }

    /**
     * Set command domain
     *
     * @param mixed $domain the domain spec
     *
     * @return $this
     *
     * @access public
     */
    public function domain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * Set responder
     *
     * @param mixed $responder responser spec
     *
     * @return $this
     *
     * @access public
     */
    public function responder($responder)
    {
        $this->responder = $responder;
        return $this;
    }
}
