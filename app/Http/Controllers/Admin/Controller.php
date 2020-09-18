<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $user=null;
    public function __construct()
    {
        $this->user = Auth::user();
    }
    //
}
