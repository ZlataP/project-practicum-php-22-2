<?php

namespace Tgu\Perminova\PhpUnit\Blog\Container;

class SomeClassWithParameter
{
    public function __construct(
        private int $value
    )
    {
    }
    public function geyValue():int
    {
        return $this->value;
    }
}<?php
