<?php
namespace Cadre\CliAdr\Input;

use Aura\Cli\Context;
use Aura\Cli\Help;

class Index implements HelpAwareInterface
{
    public function help(Help $help)
    {
        $help->setSummary('Lists commands');

        return $help;
    }

    public function __invoke(Context $context)
    {
        $getopt = $context->getopt([]);
        return [$getopt->get(2)];
    }
}
