<?php
namespace Cadre\CliAdr;

use Aura\Di\Injection\InjectionFactory;

class Resolver
{
    protected $injectionFactory;

    public function __construct(InjectionFactory $injectionFactory)
    {
        $this->injectionFactory = $injectionFactory;
    }

    public function __invoke($spec)
    {
        if (is_string($spec)) {
            return $this->injectionFactory->newInstance($spec);
        }

        if (is_array($spec) && is_string($spec[0])) {
            $spec[0] = $this->injectionFactory->newInstance($spec[0]);
        }

        return $spec;
    }
}
