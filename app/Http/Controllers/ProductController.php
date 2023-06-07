<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::select(
            'products.id',
            'reference',
            'products.name',
            'products.description',
            'purchase_price',
            'sale_price',
            'id_cat_fk',
            'photo',
            'categories.name as category'
        )
            ->join('categories', 'categories.id', '=', 'products.id_cat_fk')->paginate(10);

        $categories = Category::all();
        return Inertia::render('Products/index', ['products' => $products, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $product = request()->except('_token');
        if ($request->hasFile('photo')) {

            $product['photo'] = $request->file('photo')->store('uploads', 'public');
        }

        Product::insert($product);
        return redirect('products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return redirect('products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('products');
    }
}
