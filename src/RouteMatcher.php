<?php

namespace SunbirdRouter;

use SunbirdRouter\Match;
use SunbirdRouter\RouteCollection;

class RouteMatcher
{

    public function matchCollection(RouteCollection $collection, $path)
    {
        foreach (array_values($collection->getAll()) as $route) {
            if ($route->getPath() == $path) {
                return new Match($route);
            }

            $matchedParameters = array();

            if (preg_match('#^' . $route->getRegexp() . '$#Du', $path, $matchedParameters)) {
                foreach (array_keys($matchedParameters) as $token) {
                    if (is_int($token)) {
                        unset($matchedParameters[$token]);
                    }
                }

                return new Match($route, $matchedParameters);
            }
        }

        return false;
    }

}
