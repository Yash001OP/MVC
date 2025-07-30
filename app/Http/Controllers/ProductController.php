<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(10);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['product_name', 'product_description', 'category_id']);
        
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            try {
                $image->move(storage_path('app/public/products'), $imageName);
                $data['product_image'] = 'products/' . $imageName;
            } catch (\Exception $e) {
                Log::error('Failed to store image: ' . $e->getMessage());
            }
        }

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully!');
    }

    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['product_name', 'product_description', 'category_id']);
        
        if ($request->hasFile('product_image')) {
            if ($product->product_image) {
                Storage::delete('public/' . $product->product_image);
            }
            
            $image = $request->file('product_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            try {
                $image->move(storage_path('app/public/products'), $imageName);
                $data['product_image'] = 'products/' . $imageName;
            } catch (\Exception $e) {
                Log::error('Failed to store image: ' . $e->getMessage());
            }
        }

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->product_image) {
            Storage::delete('public/' . $product->product_image);
        }
        
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function bulkDelete(Request $request)
    {
        $productIds = json_decode($request->product_ids, true);
        
        if (!$productIds || !is_array($productIds)) {
            return redirect()->route('products.index')
                ->with('error', 'Invalid product selection.');
        }

        $request->validate([
            'product_ids' => 'required|string'
        ]);

        $products = Product::whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            if ($product->product_image) {
                Storage::delete('public/' . $product->product_image);
            }
        }

        Product::whereIn('id', $productIds)->delete();

        return redirect()->route('products.index')
            ->with('success', count($productIds) . ' products deleted successfully!');
    }
}
