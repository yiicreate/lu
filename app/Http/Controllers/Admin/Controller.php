<?php

namespace App\Http\Controllers\Admin;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $user=null;
    public function __construct()
    {
        $this->user = app("auth")->user();
    }
    //
}
