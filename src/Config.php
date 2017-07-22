<?php
namespace Cadre\CliAdr;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;

use Arbiter;
use Aura\Cli;

class Config extends ContainerConfig
{
    public function define(Container $di)
    {
        $di->set('cadre:cliadr/adr', $di->lazyNew(Adr::class));
        $di->set('cadre:cliadr/resolver', $di->newResolutionHelper());
        $di->set('cadre:cliadr/router:map', $di->lazyNew(Router\Map::class));

        $di->params[Router\Map::class] = [
            'protoRoute' => $di->lazyNew(Router\Route::class)
        ];

        $di->params[Router\Matcher::class] = [
            'map' => $di->lazyGet('cadre:cliadr/router:map')
        ];

        $di->params[Adr::class] = [
            'map' => $di->lazyGet('cadre:cliadr/router:map'),
            'actionFactory' => $di->lazyNew(ActionFactory::class),
            'handler' => $di->lazyNew(Arbiter\ActionHandler::class)
        ];

        $di->params[ActionFactory::class] = [
            'matcher' => $di->lazyNew(Router\Matcher::class)
        ];

        $di->params[Input\AbstractStdioInput::class] = [
            'stdio' => $di->lazyGetCall('cadre:cliadr/adr', 'getStdio')
        ];

        $di->params[Arbiter\ActionHandler::class] = [
            'resolver' => $di->lazyGet('cadre:cliadr/resolver')
        ];

        $di->params[Cli\Help::class] = [
            'option_factory' => $di->lazyNew(Cli\Context\OptionFactory::class)
        ];

        $di->params[Command\AbstractMetaCommand::class] = [
            'map'      => $di->lazyGet('cadre:cliadr/router:map'),
            'help'     => $di->lazyNew(Cli\Help::class),
            'resolver' => $di->lazyGet('cadre:cliadr/resolver'),
        ];
    }

    public function modify(Container $di)
    {
        $adr = $di->get('cadre:cliadr/adr');

        $adr->route('help', Command\Help::class)
            ->input(Input\Help::class);

        $adr->route('index', Command\Index::class)
            ->input(Input\Index::class);
    }
}
