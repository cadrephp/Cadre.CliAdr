# Cadre.CliAdr

This is a proof of concept command line Action-Domain-Responder (ADR) implementation.

It's heavily inspired by [Radar](https://github.com/radarphp/Radar.Project).

## Example

```php
use Aura\Cli\CliFactory;
use Aura\Cli\Context;
use Aura\Cli\Help;
use Aura\Cli\Stdio;
use Cadre\CliAdr\Boot;
use Cadre\CliAdr\Input\HelpAwareInterface;

require __DIR__ . '/vendor/autoload.php';

$boot = new Boot();
$adr = $boot->adr();

$adr->route('hello', function ($name) {
    return "Hello, {$name}";
})->input(new class implements HelpAwareInterface {
    public function help(Help $help)
    {
        $help->setSummary('Hello, World');
        $help->setOptions([
            '#name?' => 'First name [default: "World"]',
        ]);

        return $help;
    }

    public function __invoke(Context $context)
    {
        $getopt = $context->getopt([]);
        return [$getopt->get(2, 'World')];
    }
});

$factory = new CliFactory();
$context = $factory->newContext($GLOBALS);
$stdio = $factory->newStdio();

exit($adr->run($context, $stdio));

```
