<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $user=null;
    public function __construct()
    {
        $this->middleware("auth");
        $this->user = app("auth")->user();
    }
    //
}
