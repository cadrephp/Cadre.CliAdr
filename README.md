# Cadre.CliAdr

This is a proof of concept command line Action-Domain-Responder (ADR) implementation.

It's heavily inspired by [Radar](https://github.com/radarphp/Radar.Project).

## Example

```php
use Aura\Cli\CliFactory;
use Cadre\CliAdr\Boot;

require __DIR__ . '/../vendor/autoload.php';

$boot = new Boot();
$adr = $boot->adr();

$adr->route('test', function ($params) {
    return 'This is a test.';
});

$factory = new CliFactory();
$context = $factory->newContext($GLOBALS);
$stdio = $factory->newStdio();

exit($adr->run($context, $stdio));
```
