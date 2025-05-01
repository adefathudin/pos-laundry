<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class HomeController extends BaseController
{
    
    public function index()
    {
        return view('home.index');
    }
}
