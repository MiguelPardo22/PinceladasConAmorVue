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
        $request->validate([
            'name' => 'required|max:150',
            'state' => 'required|max:20'
        ]);
        $category = new Category($request->input());
        $category->save();
        return redirect('categories');
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
        $request->validate([
            'name' => 'required|max:150',
            'state' => 'required|max:20'
        ]);
        $category->update($request->input());
        return redirect('categories');
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('categories');
    }
}
