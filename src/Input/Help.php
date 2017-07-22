<?php
namespace Cadre\CliAdr\Input;

use Aura\Cli\Context;
use Aura\Cli\Help as AuraCliHelp;

class Help implements HelpAwareInterface
{
    public function help(AuraCliHelp $help)
    {
        $help->setSummary('Display this help message');
        $help->setOptions(array(
            '#command?' => 'The command name [default: "help"]',
        ));

        return $help;
    }

    public function __invoke(Context $context)
    {
        $getopt = $context->getopt([]);
        return [$getopt->get(2, 'help')];
    }
}
