<?php

namespace SunbirdRouter;

use SunbirdRouter\Exception\MissingParametersException;

class UrlGenerator
{

    public function generate($path, $parameters = array())
    {
        $generatedPath = $path;
        $generatedPath = str_replace(array_keys($parameters), array_values($parameters), $path);
        $generatedPath = preg_replace(array('#</:(\w+)>#', '#<#', '#>#'), '', $generatedPath);

        $tokens = array();

        if (preg_match_all('/:(\w+)/', $generatedPath, $tokens)) {
            throw new MissingParametersException($path, array_values($tokens[1]));
        }

        return $generatedPath;
    }

}
