<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;

class HelloController
{
    public function index(Request $request)
    {
        $name = $request->attributes->get('name');
        echo 'Hello '.$name;
    }
}
