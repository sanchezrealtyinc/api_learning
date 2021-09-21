<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create($request->only(
            'name',
            'description',
            'weight_class',
            'minimun_price',
            'price_currency',
            'category_id'
        ));
        
        return (new ProductResource($product))->additional([
            'message' => 'Product added Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
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
        $product->update($request->only(
            'name',
            'description',
            'weight_class',
            'minimun_price',
            'price_currency',
            'category_id'
        ));

        return (new ProductResource($product))->additional([
            'message' => 'Product updated Successfully'
        ]);
    }

    public function filters(Request $request){
        
        $query = Product::query();
        
        //total of the products
        $total = $query->count();

        //Filters for name and description
        if ( $search = $request->input('s') ) {
            $query->whereRaw("name LIKE '%" . $search . "%'")
                ->orWhereRaw("description LIKE '%" . $search . "%'");
        }

        //Ascending and descending order of products
        if($sort = $request->input('sort')){
            if($sort === 'asc'){
                $query->orderBy('minimun_price', 'asc');
            }else if($sort === 'desc'){
                $query->orderBy('minimun_price', 'desc');
            }   
        }

        //Pagination
        $page = $request->input('page', 1);
        $perPage = 9;
        
        $products = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

        return [
            'data' => ProductResource::collection($products->forPage($page, 9)->values()),
            'meta' => [
                'total' => $total,
                'page' => $page,
                'last_page' => ceil($total / $perPage)
            ]
        ];
    } 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return (new ProductResource($product))->additional([
            'message' => 'Product removed Successfully'
        ]);
    }
}
