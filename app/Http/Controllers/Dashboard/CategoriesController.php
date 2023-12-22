<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $categories = Category::with('parent')
            // LeftJoin('categories as parents', 'parents.id', 'categories.parent_id')
            //     ->select([
            //         'categories.*',
            //         'parents.name as parent_name',
            //     ])
            // ->select('categories.*')
            // ->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as product_count')
            ->withCount(['products' => function ($query) {
                $query->where('status', 'active');
            }])
            ->filter($request->query())
            ->orderBy('name')
            ->paginate();


        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Category::get();
        $category = new Category();
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Category::rules());

        $request->merge([
            'slug' => str::slug($request->post('name'))
        ]);

        $data = $request->except('image');
        $data['image'] = $this->uploadimage($request);

        $catrgory = Category::create($data);
        return redirect()->route('categories')
            ->with('success', 'Category Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category =  Category::findOrFail($id);
        $parents  =  Category::where('id', '!=', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->Orwhere('parent_id', '!=', $id);
            })->get();

        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate(Category::rules($id));

        $category = Category::findOrFail($id);

        $old_image = $category->image;

        $data = $request->except('image');

        $new_image = $this->uploadimage($request);
        if ($new_image) {
            $data['image'] = $new_image;
        }

        $category->update($data);
        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('categories')
            ->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories')
            ->with('success', 'Category Deleted');
    }


    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('categories.trash');
    }

    public function forcedelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->forceDelete();
        return redirect()->route('categories.trash');
    }
}
