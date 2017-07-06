<?php
namespace Cadre\CliAdr\Command;

use Aura\Cli\Help as AuraCliHelp;
use Cadre\CliAdr\Input\HelpAware;
use Cadre\CliAdr\Resolver;
use Cadre\CliAdr\Route;
use Cadre\CliAdr\Router;
use PHPUnit\Framework\TestCase;

class HelpTest extends TestCase
{
    public function testHelpAware()
    {
        $name = uniqid();

        $route = new Route();
        $route->name($name);
        $route->input('InputClassName');

        $router = $this->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->getMock();

        $router->expects($this->once())
            ->method('match')
            ->with($name)
            ->willReturn($route);

        $resolver = $this->getMockBuilder(Resolver::class)
            ->disableOriginalConstructor()
            ->getMock();

        $resolver->expects($this->once())
            ->method('__invoke')
            ->with('InputClassName')
            ->willReturn(new class implements HelpAware {
                public function help(AuraCliHelp $help) {
                    $help->setSummary('The summary');
                    return $help;
                }
            });

        $command = new Help($router, $resolver);

        $text = ($command)($name);

        $this->assertEquals(
            [
                "<<bold>>SUMMARY<<reset>>",
                "    <<bold>>{$name}<<reset>> -- The summary",
                "",
                "<<bold>>USAGE<<reset>>",
                "    <<ul>>{$name}<<reset>>",
                "",
            ],
            explode("\n", $text)
        );
    }

    public function testInvokeable()
    {
        $name = uniqid();

        $route = new Route();
        $route->name($name);
        $route->input('InputClassName');

        $router = $this->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->getMock();

        $router->expects($this->once())
            ->method('match')
            ->with($name)
            ->willReturn($route);

        $resolver = $this->getMockBuilder(Resolver::class)
            ->disableOriginalConstructor()
            ->getMock();

        $resolver->expects($this->once())
            ->method('__invoke')
            ->with('InputClassName')
            ->willReturn(new class {});

        $command = new Help($router, $resolver);

        $text = ($command)($name);

        $this->assertEquals(
            [
                "No help available.",
                "",
            ],
            explode("\n", $text)
        );
    }
}
