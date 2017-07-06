<?php
namespace Cadre\CliAdr;

class Route
{
    protected $name;
    protected $input = 'Cadre\CliAdr\Input\Input';
    protected $domain;
    protected $responder = 'Cadre\CliAdr\Responder\Responder';

    public function __get($key)
    {
        return $this->$key;
    }

    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    public function input($input)
    {
        $this->input = $input;
        return $this;
    }

    public function domain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    public function responder($responder)
    {
        $this->responder = $responder;
        return $this;
    }
}
