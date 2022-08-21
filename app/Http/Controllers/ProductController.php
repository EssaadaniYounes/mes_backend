<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products =Product::all();
        return response([
            'success'=>true,
            'data'=>$products
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create($request->all());
        if($product){
            return response()->json([
                'success'=>true,
                'data'=>$product
            ],200);
        }
        else{
            return response()->json([
                'success'=>false
            ],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if($product){
            return response()->json([
                'success'=>true,
                'data'=>$product
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'data'=>'Category not found'
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if($product){
            $updated = $product::update($request->all());
            if($updated){
                return response()->json([
                    'success'=>true,
                    'data'=>$updated
                ],200);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'data'=>'Cannot update this product try again!!'
                ],400);
            }

        }
        else{

            return response()->json([
                'success'=>false,
                'data'=>'Product not found'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::find($id);
        if($product){
            if($product->delete())
            {
                return response()->json([
                    'success'=>true,
                    'data'=>'Product deleted successfully'
                ],200);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'data'=>'Cannot delete this product'
                ],400);
            }
        }else{
            return response()->json([
                'success'=>false,
                'data'=>'Product not found'
            ],404);
        }
    }
}
