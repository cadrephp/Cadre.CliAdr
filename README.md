# Cadre.CliAdr

This is a proof of concept command line Action-Domain-Responder (ADR) implementation.

It's heavily inspired by [Radar](https://github.com/radarphp/Radar.Project).

## Example

```php
use Aura\Di\ContainerBuilder;
use Aura\Cli\CliFactory;

require __DIR__ . '/../vendor/autoload.php';

$di = (new ContainerBuilder())
    ->newConfiguredInstance([
        'Cadre\CliAdr\Config',
    ]);

$adr = $di->get('cadre:cliadr/adr');

$factory = new CliFactory();
$context = $factory->newContext($GLOBALS);
$stdio = $factory->newStdio();

$adr->route('test', function ($params) {
    return 'This is a test.';
});

exit($adr->run($context, $stdio));
```
