<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Products;


class ProductsController extends BaseController
{

    public function index()
    {
        $products = Products::all();
        return view('products.index', ['products' => $products]);
    }

    public function list(Request $request)
    {
        $columns = ['id', 'name', 'price', 'stock', 'image'];
        $length = $request->input('length');
        $column = $request->input('order.0.column');
        $dir = $request->input('order.0.dir');
        $searchValue = $request->input('search.value');
        $start = $request->input('start');

        $query = Products::select($columns);

        $totalData = $query->count();

        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%")
                    ->orWhere('price', 'like', "%{$searchValue}%")
                    ->orWhere('stock', 'like', "%{$searchValue}%");
            });
        }

        $filteredData = $query->count();

        $data = $query->orderBy($columns[$column], $dir)
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'data' => $data,
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $filteredData,
        ]);
    }

    public function show($id)
    {
        $product = Products::find($id);
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:products,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = Products::find($request->input('id'));

        if ($request->hasFile('image')) {
            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->move(public_path('assets/images/products'), $imageName);
            $product->image = $imageName;
        }

        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->save();

        return response()->json([
            'message' => 'Product updated successfully',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->move(public_path('assets/images/products'), $imageName);
        }

        Products::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'image' => $imageName ?? null,
        ]);

        return response()->json([
            'message' => 'Product created successfully',
        ]);
    }

    public function destroy(Request $request)
    {
        $product = Products::find($request->input('id'));
        if ($product) {
            $product->delete();
            return response()->json([
                'message' => 'Product deleted successfully',
            ]);
        } else {
            return response()->json([

                'message' => 'Product not found',
            ], 404);
        }
    }

}
