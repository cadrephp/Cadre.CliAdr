<?php
namespace Cadre\CliAdr\Input;

use Aura\Cli\Help;

interface HelpAwareInterface
{
    /**
     * Configure Aura\Cli help object
     *
     * @param Help $help the help object
     *
     * @return null
     *
     * @access public
     */
    public function help(Help $help);
}
