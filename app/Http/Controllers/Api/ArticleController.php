<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Article;


class ArticleController extends ApiController
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
            $allArticle = Article::with(['article_category'])
                ->where('title', 'LIKE', "%{$search}%");
              
        } else {
            $allArticle = Article::with(['article_category'])
                ->whereNotNull('id')->orderBy('id', 'desc');
        }
        
        
        $article = $allArticle->paginate(3);
        if($article){
            return $this->successResponse($article);
        }else{
            return $this->successResponse(null, 'No Article', 404);
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
            'title' => 'bail|required|max:200',
            'content' => 'bail|required',
            'article_category_id' => 'required',
            
        ]);

        $article = Article::create($request->all());
        if($article){
            return $this->successResponse($article, 'Article Created', 201);
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
        $article = Article::find($id);
        if ($article){
            $article->article_category = $article->article_category;
            return $this->successResponse($article);
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
            'title' => 'bail|required|max:200',
            'content' => 'bail|required',
            'article_category_id' => 'required',
            
        ]);
        $result = Article::where('id', $id)
                ->update($request->all());

        if ($result === 1){
            $article = Article::find($id);
            return $this->successResponse($article, 'Article Updated');
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
        $article = Article::find($id);
        $article->delete();

        if ($article->trashed()){
            return $this->successResponse(null, 'Article Deleted');
        }else{
            return $this->errorResponse('Delete Failed', 401);
        }
    }
}
