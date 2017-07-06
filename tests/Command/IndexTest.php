<?php
namespace Cadre\CliAdr\Command;

use Aura\Cli\Help as AuraCliHelp;
use Cadre\CliAdr\Input\HelpAware;
use Cadre\CliAdr\Resolver;
use Cadre\CliAdr\Route;
use Cadre\CliAdr\Router;
use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
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
            ->method('getRoutes')
            ->willReturn([$route]);

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

        $command = new Index($router, $resolver);

        $text = ($command)($name);

        $this->assertEquals(
            [
                "<<bold>>USAGE<<reset>>",
                "    command [options] [arguments]",
                "",
                "<<bold>>COMMANDS<<reset>>",
                "    {$name}",
                "        The summary",
                ""
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
            ->method('getRoutes')
            ->willReturn([$route]);

        $resolver = $this->getMockBuilder(Resolver::class)
            ->disableOriginalConstructor()
            ->getMock();

        $resolver->expects($this->once())
            ->method('__invoke')
            ->with('InputClassName')
            ->willReturn(new class {});

        $command = new Index($router, $resolver);

        $text = ($command)($name);

        $this->assertEquals(
            [
                "<<bold>>USAGE<<reset>>",
                "    command [options] [arguments]",
                "",
                "<<bold>>COMMANDS<<reset>>",
                "    {$name}",
                "        No description",
                ""
            ],
            explode("\n", $text)
        );
    }
}
