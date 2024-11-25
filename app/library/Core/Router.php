<?php

namespace App\Core;

class Router
{
    public const string DEFAULT_CONTROLLER = 'IndexController';
    public const string DEFAULT_ACTION = 'indexAction';

    private string $controllerClassName;
    private string $actionName;

    public function __construct(string $uri)
    {
        $uri = strtolower($uri);
        $uri = strtok($uri, '?');
        $uri = trim($uri, '/');

        $uriParts = $uri ? explode('/', $uri) : [];
        switch (count($uriParts)) {
            case 0:
                $this->controllerClassName = static::DEFAULT_CONTROLLER;
                $this->actionName = static::DEFAULT_ACTION;
                break;
            case 1:
                $this->controllerClassName = $this->convertKebabCaseToCamelCase($uriParts[0]) . 'Controller';
                $this->actionName = static::DEFAULT_ACTION;
                break;
            case 2:
                $this->controllerClassName = $this->convertKebabCaseToCamelCase($uriParts[0]) . 'Controller';
                $this->actionName = lcfirst($this->convertKebabCaseToCamelCase($uriParts[1])) . 'Action';
                break;
            default:
                throw new RoutingException('Can\'t parse requested uri. Got too many parts.');
        }
    }

    private function convertKebabCaseToCamelCase($input): string
    {
        return str_replace('-', '', ucwords($input, '-'));
    }

    public function getControllerClassName(): string
    {
        return $this->controllerClassName;
    }

    public function getActionName(): string
    {
        return $this->actionName;
    }
}
