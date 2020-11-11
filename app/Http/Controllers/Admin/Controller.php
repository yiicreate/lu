<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use http\Client\Request;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    protected $user=null;
    public function __construct()
    {
        $this->user = Auth::user();
    }
}
