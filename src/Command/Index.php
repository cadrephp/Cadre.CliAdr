<?php
namespace Cadre\CliAdr\Command;

use Aura\Cli\Context\OptionFactory;
use Aura\Cli\Help;
use Cadre\CliAdr\Input\HelpAware;
use Cadre\CliAdr\Router;

class Index
{
    private $router;
    private $resolver;

    public function __construct(Router $router, callable $resolver)
    {
        $this->router = $router;
        $this->resolver = $resolver;
    }

    public function __invoke()
    {
        $list = $this->getUsage()
              . $this->getCommands()
        ;

        return rtrim($list) . PHP_EOL;
    }

    private function getUsage()
    {
        return "<<bold>>USAGE<<reset>>" . PHP_EOL
             . "    command [options] [arguments]" . PHP_EOL . PHP_EOL;
    }

    private function getCommands()
    {
        $commands = [];

        $routes = $this->router->getRoutes();

        foreach ($routes as $route) {
            $input = ($this->resolver)($route->input);
            if ($input instanceof HelpAware) {
                $help = $input->help(new Help(new OptionFactory));
                $commands[$route->name] = $help->getSummary();
            }
            if (empty($commands[$route->name])) {
                $commands[$route->name] = 'No description';
            }
        }

        ksort($commands);

        $text = '';
        foreach ($commands as $name => $summary) {
            $text .= "    {$name}" . PHP_EOL;
            $text .= "        {$summary}" . PHP_EOL;
        }

        return "<<bold>>COMMANDS<<reset>>" . PHP_EOL
             . "    " . trim($text) . PHP_EOL . PHP_EOL;
    }
}
