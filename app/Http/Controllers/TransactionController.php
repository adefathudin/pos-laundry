<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Products;

class TransactionController extends BaseController
{
    public function index()
    {
        $products = Products::all();
        return view('transactions.index', ['products' => $products]);
    }
}
