<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allProductCategory = ProductCategory::whereNotNull('id');
        if($request->has('name')){
            $allProductCategory = ProductCategory::where('name', $request->name);
        }
        if($request->has('parent_id')){
            $allProductCategory = ProductCategory::where('parent_id', $request->parent_id);
        }
        if($request->has('description')){
            $allProductCategory = ProductCategory::where('description', $request->description);
        }
        

        return $allProductCategory->paginate(3)->toJson();
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product_category = ProductCategory::create($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product_category = ProductCategory::find($id);
        if ($product_category){
            return $product_category->toJson();
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
        ProductCategory::where('id', $id)
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
        $result = ProductCategory::descendantsAndSelf($id);
        foreach($result as $node){
            $node->delete();
        }
    }
}
