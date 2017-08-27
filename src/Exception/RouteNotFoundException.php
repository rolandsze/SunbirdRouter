<?php

namespace SunbirdRouter\Exception;

use \RuntimeException;

class RouteNotFoundException extends RuntimeException
{

    public function __construct($route)
    {
        parent::__construct(sprintf('The "%s" route was not found.', $route), 404);
    }

}
