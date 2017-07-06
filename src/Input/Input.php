<?php
namespace Cadre\CliAdr\Input;

use Aura\Cli\Context;
use Aura\Cli\Help;
use Aura\Cli\Stdio;

class Input
{
    public function __invoke(Context $context, Stdio $stdio)
    {
        $getopt = $context->getopt(['v,vv,vvv,verbose']);
        return [$getopt->get()];
    }
}
