<?php

namespace SunbirdRouter\Exception;

use \OutOfBoundsException;

class MatchNotFoundException extends OutOfBoundsException
{

    public function __construct($path)
    {
        parent::__construct(sprintf('The path "%s" has no match.', $path), 404);
    }

}
