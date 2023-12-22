<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\ImportProducts;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $products = Product::with(['category', 'store'])->paginate();
        // SELECT * FROM products
        // SELECT * FROM categories WHERE id IN (..)
        // SELECT * FROM stores WHERE id IN (..)

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Product::create($request->all());
        return redirect()->route('products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $product = Product::findOrFail($id);
        // $this->authorize('view', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        // $this->authorize('update', $product);

        $tags = implode(',', $product->tags()->pluck('name')->toArray());

        return view('dashboard.products.edit', compact('product', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // $this->authorize('update', $product);

        $product->update($request->except('tags'));
        $tags = explode(',', $request->tags);
        $tag_ids = [];
        $saved_tags = Tag::all();
        foreach ($tags as $t_name) {
            $slug = Str::slug($t_name);
            $tag = $saved_tags->where('slug', $slug)->first();
            if (!$tag) {
                $tag = Tag::create([
                    'name' => $t_name,
                    'slug' => $slug,
                ]);
            }
            $tag_ids[] = $tag->id;
        }

        $product->tags()->sync($tag_ids);

        $old_image = $product->image;
        $new_image = $request->file('image');

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }

        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $image = $request->file('image');
                $filename = urlencode(str_replace(' ', '-', $product->name));
                $ext  = $image->getClientOriginalExtension();
                $path = $image->storeAs('uploads/products/', "$filename." . $ext, 'public');
                $product->image = $path;
                $product->save();
            }
        }

        return back()
            ->with('success', 'Product updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // $this->authorize('delete', $product);
    }
}
