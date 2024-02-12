<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProdcutResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::filter($request->query())
            ->with('category:id,name','store:id,name','tags:id,name')
            ->paginate();
        return ProdcutResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'name'          => 'required|string',
            'description'   => 'nullable|string',
            'category_id'   => 'required|exists:categories,id',
            'status'        => 'in:active,inactive',
            'price'         => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
            'store_id'      => 'required|required|exists:stores,id',
        ]);

        $user = Auth::guard('sanctum')->user();

        if ($user && $user->tokenCan('products.create')) {
            return abort(403,'Not Allowed');
        }
        $product = product::create($request->all());

        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

        return new ProdcutResource($product);
        // return product::findOrFail($id)
        //        ->load('category:id,name','store:id,name','tags:id,name');
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
        $request->validate([

            'name'          => 'sometimes|required|string',
            'description'   => 'nullable|string',
            'category_id'   => 'sometimes|required|exists:categories,id',
            'status'        => 'in:active,inactive',
            'price'         => 'sometimes|required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
            'store_id'      => 'sometimes|required|required|exists:stores,id',
        ]);

        $user = Auth::guard('sanctum')->user();

        if ($user && !$user->tokenCan('products.update')) {
            return response([
                'message' => 'Not Allowed',
                code
            ]);
        }

        $product->update($request->all());

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::guard('sanctum')->user();

        if ($user && !$user->tokenCan('products.delete')) {
            return abort(403,'Not Allowed');
        }

        product::destroy($id);

        return Response::json([
            'message' => 'product deleted successfully',
        ]);
    }
}
