<?php

namespace Cadre\CliAdr\Input;

use Aura\Cli\Stdio;

abstract class AbstractStdioInput
{
    protected $stdio;

    public function __construct(Stdio $stdio)
    {
        $this->stdio = $stdio;
    }
}
