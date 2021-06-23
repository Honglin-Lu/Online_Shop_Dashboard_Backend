<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;


class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allArticleCategory = ArticleCategory::whereNotNull('id');
        if($request->has('name')){
            $allArticleCategory = ArticleCategory::where('name', $request->name);
        }
        if($request->has('parent_id')){
            $allArticleCategory = ArticleCategory::where('parent_id', $request->parent_id);
        }
        if($request->has('description')){
            $allArticleCategory = ArticleCategory::where('description', $request->description);
        }
        

        return $allArticleCategory->paginate(3)->toJson();
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
            return $article_category->toJson();
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
        ArticleCategory::where('id', $id)
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
        $result = ArticleCategory::descendantsAndSelf($id);
        foreach($result as $node){
            $node->delete();
        }
    }
}
