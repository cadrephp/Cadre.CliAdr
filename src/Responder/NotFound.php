<?php
namespace Cadre\CliAdr\Responder;

use Aura\Cli\Context;
use Aura\Cli\Status;
use Aura\Cli\Stdio;

class NotFound
{
    public function __invoke(Context $context, Stdio $stdio, $commandName = null)
    {
        $stdio->errln(sprintf("Command '%s' not found", $commandName));
        return Status::FAILURE;
    }
}
