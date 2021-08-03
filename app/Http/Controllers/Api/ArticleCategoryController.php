<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;


class ArticleCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allArticleCategory = ArticleCategory::whereNotNull('id');
        


        $article_category = $allArticleCategory->paginate(3);

        if($article_category){
            return $this->successResponse($article_category);
        }else{
            return $this->successResponse(null, 'No Article Category', 404);
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
        $article_category = ArticleCategory::create($request->all());
        if($article_category){
            return $this->successResponse($article_category, 'Article Category Created', 201);
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
        $article_category = ArticleCategory::find($id);
        if ($article_category){
            return $this->successResponse($article_category);
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
        $result = ArticleCategory::where('id', $id)
                       ->update($request->all());

        if ($result === 1){
            $employee = Employee::find($id);
            return $this->successResponse($employee, 'Employee Updated');
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
        $result = ArticleCategory::descendantsAndSelf($id);
        foreach($result as $node){
            $node->delete();
        }

        
    }
}
