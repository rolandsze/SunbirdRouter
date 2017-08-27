<?php

namespace SunbirdRouter;

use SunbirdRouter\Route;

class Match
{

    protected $route;
    protected $parameters;

    public function __construct(Route $route, $matchedParameters = array())
    {
        $this->route = $route;
        $this->parameters = array_merge($route->getParameters(), $matchedParameters);
    }

    public function getPath()
    {
        return $this->route->getPath();
    }

    public function getController()
    {
        return $this->route->getController() ?: $this->getParameter('controller');
    }

    public function getAction()
    {
        return $this->route->getAction() ?: $this->getParameter('action');
    }

    public function getParameter($key, $default = null)
    {
        return (array_key_exists($key, $this->parameters)) ? $this->parameters[$key] : $default;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

}
