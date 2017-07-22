<?php
namespace Cadre\CliAdr\Command;

use Aura\Cli\Help;
use Aura\Cli\Context\OptionFactory;
use Cadre\CliAdr\Input\HelpAwareInterface;
use Cadre\CliAdr\Resolver;
use Cadre\CliAdr\Router\Route;
use Cadre\CliAdr\Router\Map;
use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
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
            ->method('getRoutes')
            ->willReturn([$name => $route]);

        $resolver = $this->createPartialMock(\stdClass::class, ['__invoke']);

        $resolver->expects($this->once())
            ->method('__invoke')
            ->with('InputClassName')
            ->willReturn(new class implements HelpAwareInterface {
                public function help(Help $help) {
                    $help->setSummary('The summary');
                    return $help;
                }
            });

        $help = new Help(new OptionFactory);
        $command = new Index($map, $help,  $resolver);

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

        $map = $this->getMockBuilder(Map::class)
            ->disableOriginalConstructor()
            ->getMock();

        $map->expects($this->once())
            ->method('getRoutes')
            ->willReturn([$route]);

        $resolver = $this->createPartialMock(\stdClass::class, ['__invoke']);

        $resolver->expects($this->once())
            ->method('__invoke')
            ->with('InputClassName')
            ->willReturn(new class {});

        $help = new Help(new OptionFactory);
        $command = new Index($map, $help,  $resolver);

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
