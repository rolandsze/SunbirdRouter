<?php

namespace SunbirdRouter;

use SunbirdRouter\Exception\MatchNotFoundException;
use SunbirdRouter\UrlGenerator;
use SunbirdRouter\RouteMatcher;
use SunbirdRouter\RouteCollection;
use SunbirdRouter\Route;

class Router
{

    protected $generator;
    protected $collection;
    protected $matcher;

    public function __construct()
    {
        $this->collection = new RouteCollection();
        $this->matcher = new RouteMatcher();
        $this->generator = new UrlGenerator();
    }

    public function addRoutes($routes)
    {
        foreach ($routes as $name => $route) {
            list($path, $controller, $action) = $route;

            if (!array_key_exists('filters', $route)) {
                $route['filters'] = array();
            }

            if (!array_key_exists('parameters', $route)) {
                $route['parameters'] = array();
            }

            $this->addRoute($name, $path, $controller, $action, $route['filters'], $route['parameters']);
        }
    }

    public function addRoute($name, $path, $controller, $action, $filters = array(), $parameters = array())
    {
        $this->collection->addRoute($name, new Route($path, $controller, $action, $filters, $parameters));
    }

    public function getRoute($name)
    {
        return $this->collection->getRoute($name);
    }

    public function match($path)
    {
        $match = $this->matcher->matchCollection($this->collection, $path);

        if (!$match) {
            throw new MatchNotFoundException($path);
        }

        return $match;
    }

    public function generate($route, $parameters = array())
    {
        return $this->generator->generate($this->collection->getRoute($route)->getPath(), $parameters);
    }

}
