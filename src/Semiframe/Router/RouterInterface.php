<?php

declare(strict_types=1);

namespace Semiframe\Router;

interface RouterInferface
{
    /**
     * Here we add route to routing table
     * 
     * @param string $route
     * @param array $params
     * @return void
     */
    public function add(string $route, array $params) : void;

    /**
     * Dispatch the route and create controller objects and execute default method
     * 
     * @param string $url
     * @return void
     */
    public function dispatch(string $url): void;
}