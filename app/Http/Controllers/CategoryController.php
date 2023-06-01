<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;


class CategoryController extends Controller
{
    
    public function index()
    {
        $categories = Category::all();
        return Inertia::render('Categories/index', ['categories' => $categories]); 
    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }


    public function show(Category $category)
    {
        //
    }

 
    public function edit(Category $category)
    {
        //
    }

 
    public function update(Request $request, Category $category)
    {
        //
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('categories');
    }
}
