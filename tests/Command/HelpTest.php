<?php
namespace Cadre\CliAdr\Command;

use Aura\Cli\Help as AuraCliHelp;
use Aura\Cli\Context\OptionFactory;
use Cadre\CliAdr\Input\HelpAwareInterface;
use Cadre\CliAdr\Router\Route;
use Cadre\CliAdr\Router\Map;
use PHPUnit\Framework\TestCase;

class HelpTest extends TestCase
{
    public function testHelpAware()
    {
        $name = uniqid();

        $route = new Route();
        $route->name($name);
        $route->input('InputClassName');

        $map = $this->getMockBuilder(Map::class)
            ->disableOriginalConstructor()
            ->getMock();

        $map->expects($this->once())
            ->method('hasRoute')
            ->with($name)
            ->willReturn('true');

        $map->expects($this->once())
            ->method('getRoute')
            ->with($name)
            ->willReturn($route);

        $resolver = $this->createPartialMock(\stdClass::class, ['__invoke']);

        $resolver->expects($this->once())
            ->method('__invoke')
            ->with('InputClassName')
            ->willReturn(new class implements HelpAwareInterface {
            public function help(AuraCliHelp $help) {
                $help->setSummary('The summary');
                return $help;
            }
        });

        $help = new AuraCliHelp(new OptionFactory);
        $command = new Help($map, $help,  $resolver);

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

        $map = $this->getMockBuilder(Map::class)
            ->disableOriginalConstructor()
            ->getMock();

        $map->expects($this->once())
            ->method('hasRoute')
            ->with($name)
            ->willReturn(true);

        $map->expects($this->once())
            ->method('getRoute')
            ->with($name)
            ->willReturn($route);

        $resolver = $this->createPartialMock(\stdClass::class, ['__invoke']);

        $resolver->expects($this->once())
            ->method('__invoke')
            ->with('InputClassName')
            ->willReturn(new class {});

        $help = new AuraCliHelp(new OptionFactory);
        $command = new Help($map, $help,  $resolver);

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
