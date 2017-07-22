<?php
namespace Cadre\CliAdr\Input;

use Aura\Cli\Context;

class Input
{
    public function __invoke(Context $context)
    {
        $getopt = $context->getopt(['v,vv,vvv,verbose']);
        return [$getopt->get()];
    }
}
