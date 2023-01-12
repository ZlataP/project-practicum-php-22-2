<?php

namespace Tgu\Perminova\Exceptions;

use Exception;

class CommentNotFoundException extends Exception
{

    /**
     * @param string $string
     */
    public function __construct(string $string)
    {
    }
}
