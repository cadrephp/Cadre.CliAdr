<?php
namespace Cadre\CliAdr;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;

class Config extends ContainerConfig
{
    public function define(Container $di)
    {
        $di->set('cadre:cliadr/adr', $di->lazyNew('Cadre\CliAdr\Adr'));
        $di->set('cadre:cliadr/router', $di->lazyNew('Cadre\CliAdr\Router'));
        $di->set('cadre:cliadr/resolver', $di->lazyNew('Cadre\CliAdr\Resolver'));

        $di->params['Cadre\CliAdr\Adr'] = [
            'router' => $di->lazyGet('cadre:cliadr/router'),
            'resolver' => $di->lazyGet('cadre:cliadr/resolver'),
        ];

        $di->params['Cadre\CliAdr\Router'] = [
            'protoRoute' => $di->lazyNew('Cadre\CliAdr\Route'),
        ];

        $di->params['Cadre\CliAdr\Resolver']['injectionFactory'] = $di->getInjectionFactory();
    }
}
