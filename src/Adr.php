<?php
namespace Cadre\CliAdr;

use Aura\Cli\Context;
use Aura\Cli\Stdio;

class Adr
{
    private $router;
    private $resolver;

    public function __construct(Router $router, Resolver $resolver)
    {
        $this->router = $router;
        $this->resolver = $resolver;
    }

    public function __call($method, array $params)
    {
        return call_user_func_array([$this->router, $method], $params);
    }

    public function run(Context $context, Stdio $stdio)
    {
        $name = $context->getopt([])->get(1);
        $route = $this->router->match($name);

        $responder = ($this->resolver)($route->responder);
        if (! $responder) {
            throw new \Exception('Could not resolve responder for action.');
        }

        $domain = ($this->resolver)($route->domain);
        if (! $domain) {
            return $responder($context, $stdio);
        }

        $params = [];
        $input = ($this->resolver)($route->input);
        if ($input) {
            $params = (array) $input($context, $stdio);
        }

        $payload = call_user_func_array($domain, $params);
        return $responder($context, $stdio, $payload);
    }
}
