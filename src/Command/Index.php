<?php
namespace Cadre\CliAdr\Command;

use Cadre\CliAdr\Router\Route;
use Cadre\CliAdr\Input\HelpAwareInterface;

class Index extends AbstractMetaCommand
{

    /**
     * Get an index of available command
     *
     * @return string
     *
     * @access public
     */
    public function __invoke()
    {
        $list = $this->getUsage()
              . $this->getCommands();

        return rtrim($list) . PHP_EOL;
    }

    /**
     * Get usage header
     *
     * @return string
     *
     * @access protected
     */
    protected function getUsage()
    {
        return "<<bold>>USAGE<<reset>>" . PHP_EOL
             . "    command [options] [arguments]" . PHP_EOL . PHP_EOL;
    }

    /**
     * Get command index listing
     *
     * @return string
     *
     * @access protected
     */
    protected function getCommands()
    {
        $commands = [];

        $routes = $this->map->getRoutes();
        ksort($routes);

        $text = '';
        foreach ($routes as $route) {
            $name    = $route->name;
            $summary = $this->getCommandSummary($route);
            $text .= "    {$name}" . PHP_EOL;
            $text .= "        {$summary}" . PHP_EOL;
        }

        return "<<bold>>COMMANDS<<reset>>" . PHP_EOL
             . "    " . trim($text) . PHP_EOL . PHP_EOL;
    }

    /**
     * Get command summary
     *
     * Uses input spec help if input is HelpAware,
     * otherwide "No Description"
     *
     * @param Route $route command route
     *
     * @return string
     *
     * @access protected
     */
    protected function getCommandSummary(Route $route)
    {
        $input = $this->resolve($route->input);
        if (! $input instanceof HelpAwareInterface) {
            return 'No description';
        }

        $input->help($this->help);
        return $this->help->getSummary();
    }
}
