<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Product;


class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $search = $request->input('q');
        if ($search){
            $allProduct = Product::with(['product_category', 'supplier'])
                ->where('name', 'LIKE', "%{$search}%");
                
        } else {
            $allProduct = Product::with(['product_category', 'supplier'])
                ->whereNotNull('id');
        }


        $product = $allProduct->paginate(3);

        if($product){
            return $this->successResponse($product);
        }else{
            return $this->successResponse(null, 'No Product', 404);
        }
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
            'name' => 'bail|required|max:100',
            'buying_price' => 'bail|required|regex:/^\d+(\.\d{1,2})?$/',
            'selling_price' => 'bail|required|regex:/^\d+(\.\d{1,2})?$/',
            'quantity' => 'bail|required|integer|min:0',
            'description' => 'nullable|max:1000',
            'status' => 'required',
        ]);

        $product = Product::create($request->all());
        if($product){
            return $this->successResponse($product, 'Product Created', 201);
        }else{
            return $this->errorResponse('Store Failed', 401);
        }

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
           // return $product->toJson();
            return $this->successResponse($product);
        }else{
            return $this->successResponse(null, "Invalid Id !", 404);

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
        $request->validate([
            'name' => 'bail|required|max:100',
            'buying_price' => 'bail|required|regex:/^\d+(\.\d{1,2})?$/',
            'selling_price' => 'bail|required|regex:/^\d+(\.\d{1,2})?$/',
            'quantity' => 'bail|required|integer|min:0',
            'description' => 'nullable|max:1000',
            'status' => 'required',
        ]);
        
        $result = Product::where('id', $id)
                ->update($request->all());
        if ($result === 1){
            $product = Product::find($id);
            return $this->successResponse($product, 'Product Updated');
        }else{
            return $this->errorResponse('Update Failed', 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        if ($product->trashed()){
            return $this->successResponse(null, 'Product Deleted');
        }else{
            return $this->errorResponse('Delete Failed', 401);
        }
    }
}
