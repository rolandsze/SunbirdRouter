<?php

namespace SunbirdRouter;

class Route
{

    protected $path;
    protected $controller;
    protected $action;
    protected $filters;
    protected $parameters;
    protected $regexp;

    public function __construct($path, $controller, $action, $filters, $parameters)
    {
        if (!is_string($path)) {
            throw new \InvalidArgumentException($path);
        }

        $this->path = $path;
        $this->controller = $controller;
        $this->action = $action;
        $this->filters = $filters;
        $this->parameters = $parameters;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getController()
    {
        return $this->controller ?: $this->getParameter('controller');
    }

    public function getAction()
    {
        return $this->action ?: $this->getParameter('action');
    }

    public function getParameter($key, $default = null)
    {
        return (array_key_exists($key, $this->parameters)) ? $this->parameters[$key] : $default;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getRegexp()
    {
        if (!$this->regexp) {
            $this->compile();
        }

        return $this->regexp;
    }

    private function compile()
    {
        $regexp = array();

        if (!empty($this->filters)) {
            foreach ($this->filters as $token => $pattern) {
                $regexp['/' . $token . '/'] = $pattern;
            }
        }

        $regexp = array_merge(
            array('/:(\w+)/' => '(?P<${1}>:${1})', '#</#' => '(?:/', '#\)>#' => '))?',), $regexp, array('#<(\w+)>:(\w+)#' => '<${1}>(\w+)')
        );

        $this->regexp = preg_replace(
            array_keys($regexp), array_values($regexp), $this->path
        );
    }

}
