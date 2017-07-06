<?php
namespace Cadre\CliAdr\Command;

use Aura\Cli\Context\OptionFactory;
use Aura\Cli\Help as AuraCliHelp;
use Cadre\CliAdr\Input\HelpAware;
use Cadre\CliAdr\Router;

class Help
{
    private $router;
    private $resolver;

    public function __construct(Router $router, callable $resolver)
    {
        $this->router = $router;
        $this->resolver = $resolver;
    }

    public function __invoke($command)
    {
        $route = $this->router->match($command);
        $input = ($this->resolver)($route->input);

        if ($input instanceof HelpAware) {
            $help = $input->help(new AuraCliHelp(new OptionFactory));
        } else {
            $help = new AuraCliHelp(new OptionFactory);
        }

        return $help->getHelp($command);
    }
}
