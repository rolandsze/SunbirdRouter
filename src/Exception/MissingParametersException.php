<?php

namespace SunbirdRouter\Exception;

use \InvalidArgumentException;

class MissingParametersException extends InvalidArgumentException
{

    public function __construct($path, $missingParameters)
    {
        parent::__construct(
            sprintf(
                'Failed to generate "%s" URL. Missing parameters: %s',
                $path,
                implode(', ', $missingParameters), 0)
        );
    }

}
