<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allProduct = Product::whereNotNull('id');
        $allProduct = Product::with(['product_category', 'supplier']);

        if($request->has('name')){
            $allProduct = Product::where('name', $request->name);
        }
        if($request->has('product_category_id')){
            $allProduct = Product::where('product_category_id', $request->product_category_id);
        }
        if($request->has('supplier_id')){
            $allProduct = Product::where('supplier_id', $request->supplier_id);
        }
        if($request->has('buying_price')){
            $allProduct = Product::where('buying_price', '<', $request->buying_price);
        }
        if($request->has('selling_price')){
            $allProduct = Product::where('selling_price', '<', $request->selling_price);
        }
        if($request->has('quantity')){
            $allProduct = Product::where('quantity', '>', $request->quantity);
        }
        if($request->has('status')){
            $allProduct = Product::where('status', $request->status);
        }

        return $allProduct->paginate(3)->toJson();
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if ($product){
            $product->product_category = $product->product_category;
            $product->supplier = $product->supplier;
            return $product->toJson();
        }else{
            return "Invalid Id !";
        }
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
        Product::where('id', $id)
                ->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
    }
}
