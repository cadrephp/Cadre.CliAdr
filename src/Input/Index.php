<?php
namespace Cadre\CliAdr\Input;

use Aura\Cli\Context;
use Aura\Cli\Help;
use Aura\Cli\Stdio;

class Index implements HelpAware
{
    public function help(Help $help)
    {
        $help->setSummary('Lists commands');

        return $help;
    }

    public function __invoke(Context $context, Stdio $stdio)
    {
        $getopt = $context->getopt([]);
        return [$getopt->get(2)];
    }
}
