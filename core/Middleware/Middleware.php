<?php

namespace core\Middleware;

use core\Http\Request;

interface Middleware
{
    public function handle(Request $request);
}