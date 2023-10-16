<?php

declare(strict_types=1);

namespace Semiframe\Router;

use Exception;
use Semiframe\Router\RouterInferface;

class Router implements RouterInferface
{
    /**
     * Return an array of routes from routing table
     * @var array
     */
    protected array $routes = [];

    /**
     * Return array of route parameters
     * @var array
     */

    protected array $params = [];

    /**
     * Add suffix for controller name
     * @var string
     */

    protected string $controllerSuffix = 'controller';

    /**
     * @inheritDoc
     */

    public function add(string $route, array $params = []): void
    {
        $this->routes[$route] = $params;
    }

    /**
     * @inheritDoc
     */

    public function dispatch(string $url): void
    {
        if ($this->match($url)) {
            $controllerString = $this->params['controller'];
            $controllerString = $this->transformUpperCamelcase($controllerString);
            $controllerString = $this->getNamespcae($controllerString);

            if (class_exists($controllerString)) {
                $controllerObject = new $controllerString();
                $action = $this->params['action'];
                $action = $this->transformCamelCase($action);

                if (is_callable([$controllerObject, $action])) {
                    $controllerObject->$action();
                } else {
                    throw new Exception();
                }
            } else {
                throw new Exception();
            }
        } else {
            //404- page not found
            throw new Exception();
        }
    }

    public function transformUpperCamelcase(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', '', $string)));
    }

    public function transformCamelCase(string $string): string
    {
        return \lcfirst($this->transformUpperCamelcase($string));
    }

    /**
     * match the url 
     * 
     * @param string $url
     * @return bool
     */

    private function match(string $url): bool
    {

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $param) {
                    if (is_string($key)) {
                        $params[$key] = $param;
                    }
                }

                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * get the namespace for the controller
     * 
     * @param string $string
     * @return string
     */
    public function getNamespcae(string $string): string
    {
        $namespace = 'App\Controller\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }
}
