<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('categories.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['category_name', 'parent_id']);
        
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            try {
                $image->move(storage_path('app/public/categories'), $imageName);
                $data['category_image'] = 'categories/' . $imageName;
            } catch (\Exception $e) {
                Log::error('Failed to store image: ' . $e->getMessage());
            }
        }

        Category::create($data);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully!');
        }

    public function show(string $id)
    {
        $category = Category::with(['parent', 'children'])->findOrFail($id);
        return view('categories.show', compact('category'));
        }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::where('id', '!=', $id)->get();
        return view('categories.edit', compact('category', 'categories'));
    }


    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['category_name', 'parent_id']);
        
        if ($request->hasFile('category_image')) {
            if ($category->category_image) {
                Storage::delete('public/' . $category->category_image);
            }
            
            $image = $request->file('category_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            try {
                $image->move(storage_path('app/public/categories'), $imageName);
                $data['category_image'] = 'categories/' . $imageName;
            } catch (\Exception $e) {
                Log::error('Failed to store image: ' . $e->getMessage());
            }
        }

        $category->update($data);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully!');
        }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->category_image) {
            Storage::delete('public/' . $category->category_image);
        }
        
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
