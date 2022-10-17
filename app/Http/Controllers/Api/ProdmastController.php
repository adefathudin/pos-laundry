<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prodmast;
use App\Http\Resources\ProdmastResource;

class ProdmastController extends Controller
{
    public function index() {
        $prodmast = Prodmast::get();
        
        return new ProdmastResource(true,'List Data', $prodmast);
    }
}
