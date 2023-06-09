<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

        $request->validate([
            'reference' => 'required|max:10',
            'name' => 'required|max:15',
            'description' => 'required|max:255',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'id_cat_fk' => 'required',
            'photo' => 'required',
            'size' => 'required|max:30',
            'material' => 'required|max:30',
            'brand' => 'required|max:30'

        ], [
            'reference.required' => 'EL campo referencia es requerido',
            'name.required' => 'EL campo nombre es requerido',
            'description.required' => 'EL campo descripcion es requerido',
            'purchase_price.required' => 'EL campo precio de compra es requerido',
            'sale_price.required' => 'EL campo precio de venta es requerido',
            'id_cat_fk.required' => 'EL campo categoria es requerido',
            'photo.required' => 'EL campo foto es requerido',
            'size.required' => 'El campo tamaño es requerido',
            'material.required' => 'El campo material es requerido',
            'brand.required' => 'El campo marca es requerido'
        ]);

        $product = Product::create([

            'reference' => $request->reference,
            'name' => $request->name,
            'description' => $request->description,
            'purchase_price' => $request->purchase_price,
            'sale_price' => $request->sale_price,
            'id_cat_fk' => $request->id_cat_fk,
            'photo' => $request->file('photo')->store('uploads', 'public'),

        ]);

        $detail_product = Product_Detail::create([

            'size' => $request->size,
            'material' => $request->material,
            'brand' => $request->brand,
            'id_prod_fk' => $product->id,

        ]);

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
    public function update(Request $request, $id)
    {
        // $product->update($request->all());

        // $request->validate([
        //     'reference' => 'required|max:10',
        //     'name' => 'required|max:30',
        //     'description' => 'required|max:255',
        //     'purchase_price' => 'required|numeric',
        //     'sale_price' => 'required|numeric',
        //     'id_cat_fk' => 'required',
        //     'photo' => 'required',
        //     'size' => 'required|max:30',
        //     'material' => 'required|max:30',
        //     'brand' => 'required|max:30'

        // ], [
        //     'reference.required' => 'EL campo referencia es requerido',
        //     'name.required' => 'EL campo nombre es requerido',
        //     'description.required' => 'EL campo descripcion es requerido',
        //     'purchase_price.required' => 'EL campo precio de compra es requerido',
        //     'sale_price.required' => 'EL campo precio de venta es requerido',
        //     'id_cat_fk.required' => 'EL campo categoria es requerido',
        //     'photo.required' => 'EL campo foto es requerido',
        //     'size.required' => 'El campo tamaño es requerido',
        //     'material.required' => 'El campo material es requerido',
        //     'brand.required' => 'El campo marca es requerido'
        // ]);

        $productEdit = request()->except('_token', '_method');
        $productDetailEdit = request()->except('_token', '_method', 'reference', 'name',
         'description', 'purchase_price', 'sale_price', 'id_cat_fk', 'photo');

        if($request->hasFile('photo')){

            $products = Product::findOrFail($id);
            Storage::delete('public/'.$products->photo);
            $productEdit['photo'] = $request->file('photo')->store('uploads', 'public');

        }
        
        Product::where('id', '=', $id)->update($productEdit);
        Product_Detail::where('id', '=', $id)->update($productDetailEdit);
         
        return redirect('products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Product_Detail $product_detail)
    {
        $product_detail->delete();
        $product->delete();
        Storage::delete('public/' . $product->photo);
        return redirect('products');
    }
}
