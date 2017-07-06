<?php
namespace Cadre\CliAdr\Responder;

use Aura\Cli\Context;
use Aura\Cli\Status;
use Aura\Cli\Stdio;

class NotFound
{
    public function __invoke(Context $context, Stdio $stdio, $payload = null)
    {
        $name = $context->getopt([])->get(1, '');
        $stdio->errln(sprintf("Command '%s' not found", $name));
        return Status::FAILURE;
    }
}