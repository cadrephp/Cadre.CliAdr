<?php
namespace Cadre\CliAdr\Command;

use Aura\Cli\Help;
use Cadre\CliAdr\Router\Map;

abstract class AbstractMetaCommand
{

    /**
     * Router map
     *
     * @var Map
     *
     * @access protected
     */
    protected $map;

    /**
     * Aura\Cli Help object
     *
     * @var Help
     *
     * @access protected
     */
    protected $help;

    /**
     * Resolution helper
     *
     * @var callable
     *
     * @access protected
     */
    protected $resolver;

    /**
     * __construct
     *
     * @param Map      $map      router map
     * @param Help     $help     help object for help things
     * @param callable $resolver resolution helper
     *
     * @access public
     */
    public function __construct(
        Map $map,
        Help $help,
        callable $resolver
    ) {
        $this->map      = $map;
        $this->help     = $help;
        $this->resolver = $resolver;
    }

    /**
     * Use resolution helper to resolve a spec
     *
     * @param mixed $spec specification to resolve
     *
     * @return mixed
     *
     * @access protected
     */
    protected function resolve($spec)
    {
        return call_user_func($this->resolver, $spec);
    }
}
