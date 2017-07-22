<?php
namespace Cadre\CliAdr\Command;

use Cadre\CliAdr\Input\HelpAwareInterface;

class Help extends AbstractMetaCommand
{
    public function __invoke($command)
    {
        if (! $this->map->hasRoute($command)) {
            return 'Invalid command';
        }

        $route = $this->map->getRoute($command);
        $input = $this->resolve($route->input);

        if ($input instanceof HelpAwareInterface) {
            $input->help($this->help);
        }

        return $this->help->getHelp($command);
    }
}
