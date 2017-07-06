<?php
namespace Cadre\CliAdr\Input;

use Aura\Cli\Help;

interface HelpAware
{
    public function help(Help $help);
}
