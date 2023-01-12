<?php

namespace Tgu\Perminova\Blog\Http\Actions;

use Tgu\Perminova\Blog\Http\Request;
use Tgu\Perminova\Blog\Http\Response;

interface ActionInterface
{
    public function handle(Request $request):Response;
}
