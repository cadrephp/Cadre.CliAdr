<?php
namespace Cadre\CliAdr;

use Aura\Cli\Context;
use Aura\Cli\Status;
use Aura\Cli\Stdio;

class Responder
{
    public function __invoke(Context $context, Stdio $stdio, $payload = null)
    {
        if (is_string($payload)) {
            $payload = [$payload];
        }

        if (is_array($payload)) {
            foreach ($payload as $line) {
                if (!is_string($line)) {
                    $line = trim(preg_replace('!\s+!', ' ', print_r($line, true)));
                }
                $stdio->outln($line);
            }
        }

        return Status::SUCCESS;
    }
}
