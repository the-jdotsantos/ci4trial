<?php

namespace App\Controllers;

class Hello extends BaseController
{
    public function index()
    {
        return view('hello_world');
    }
}
