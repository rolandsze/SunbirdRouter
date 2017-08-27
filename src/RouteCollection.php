<?php

namespace SunbirdRouter;

use SunbirdRouter\Exception\RouteNotFoundException;
use SunbirdRouter\Route;

class RouteCollection
{

    protected $routes = array();

    public function addRoute($name, Route $route)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('The route name can only be string type.');
        }

        $this->routes[$name] = $route;
    }

    public function getRoute($name)
    {
        if (!array_key_exists($name, $this->routes)) {
            throw new RouteNotFoundException($name);
        }

        return $this->routes[$name];
    }

    public function getAll()
    {
        return $this->routes;
    }

}
