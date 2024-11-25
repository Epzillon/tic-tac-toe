<?php

namespace App\Core;

use App\Controllers\ControllerInterface;
use App\Views\AbstractView;
use App\Views\ErrorView;
use App\Views\NotFoundView;
use LogicException;
use Throwable;

class Mvc
{
    private const string CONTROLLERS_NAMESPACE = 'App\\Controllers\\';

    public function __construct()
    {
        $configPath = __DIR__ . '/../../configs/config.php';
        Config::initConfig($configPath);
    }

    public function processCurrentRequest(): void
    {
        try {
            $router = new Router($_SERVER['REQUEST_URI']);

            $controllerClassFullName = self::CONTROLLERS_NAMESPACE . $router->getControllerClassName();
            if (!class_exists($controllerClassFullName)) {
                throw new RoutingException("Controller $controllerClassFullName not found.");
            }

            $controller = new $controllerClassFullName();
            if (!$controller instanceof ControllerInterface) {
                throw new LogicException("Controller $controllerClassFullName is looks weird. Controller should implement ControllerInterface.");
            }

            $actionName = $router->getActionName();
            if (!method_exists($controller, $actionName)) {
                throw new RoutingException("Method $actionName not found in controller $controllerClassFullName.");
            }

            $view = $controller->{$actionName}();
            if (!$view instanceof AbstractView) {
                $viewType = is_object($view) ? get_class($view) : gettype($view);
                throw new LogicException("Action $controllerClassFullName::$actionName() should return AbstractView. Got $viewType instead.");
            }
        } catch (RoutingException) {
            $view = new NotFoundView();
        } catch (Throwable $e) {
            $view = new ErrorView($e);
        }

        $view->renderViewInLayout();
    }
}
