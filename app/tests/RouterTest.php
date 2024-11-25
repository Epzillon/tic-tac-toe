<?php

namespace Tests;

use App\Core\Router;
use App\Core\RoutingException;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testEmptyUrlGivesUsDefaultControllerAndActionNames(): void
    {
        $route = new Router('');

        $this->assertSame(Router::DEFAULT_ACTION, $route->getActionName());
        $this->assertSame(Router::DEFAULT_CONTROLLER, $route->getControllerClassName());
    }

    public function testCorrectUriWithDefaultAction(): void
    {
        $route = new Router('/droids');

        $this->assertSame(Router::DEFAULT_ACTION, $route->getActionName());
        $this->assertSame('DroidsController', $route->getControllerClassName());
    }

    public function testCorrectUriWithAction(): void
    {
        $route = new Router('/droids/edit');

        $this->assertSame('editAction', $route->getActionName());
        $this->assertSame('DroidsController', $route->getControllerClassName());
    }

    public function testUriWithThreePartsThrowAnException(): void
    {
        $this->expectException(RoutingException::class);
        $this->expectExceptionMessage('Can\'t parse requested uri. Got too many parts.');
        new Router('/droids/must/serve');
    }

    public function testConvertingKebabCaseInUrlToCamelCase(): void
    {
        $route = new Router('/astromech-droids/r-series');

        $this->assertSame('rSeriesAction', $route->getActionName());
        $this->assertSame('AstromechDroidsController', $route->getControllerClassName());
    }

    public function testTrailingSlashNotRuiningAnything(): void
    {
        $route = new Router('/droids/create/');

        $this->assertSame('createAction', $route->getActionName());
        $this->assertSame('DroidsController', $route->getControllerClassName());
    }

    public function testGetParametersAreIgnoring(): void
    {
        $route = new Router('/droids/remove?name=r2d2#somehash12333');

        $this->assertSame('removeAction', $route->getActionName());
        $this->assertSame('DroidsController', $route->getControllerClassName());
    }

    public function testUriInStrangeCaseIsStillWorking(): void
    {
        $route = new Router('/dRoIdS/rEpAIr');

        $this->assertSame('repairAction', $route->getActionName());
        $this->assertSame('DroidsController', $route->getControllerClassName());
    }
}
