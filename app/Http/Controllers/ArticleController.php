<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;



class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('IsAdmin');
        $this->middleware('IsAuthor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $articles =  Article::with('category','tags','comments')->latest()->get();
       return  new ArticleCollection($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $image = $request->file('image');
        $image_name = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $image_name);
        $article = Article::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'content'=>$request->content,
            'image'=>$image_name,
            'category_id'=>$request->category_id,
            'user_id'=>1,  
            // Auth::user()->id
        ]);
        $tags = $request->input('tags',[]);
        $article->tags()->attach($tags);
        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $article =  Article::with('category','tags','comments')->where('id',$article->id)->get();
        return  new ArticleCollection($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        ///
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        if($article->user_id!=1){
            return  response()->json(["error"=>'You Dont have permission to make action on it'], 404);
        }
        if ($request->hasFile('image')) {
            // delete old image
            $oldImage = public_path('images/').$article->image;
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
            // upload new image
            $image = $request->file('image');
            $imageName = time().'-'.$image->getClientOriginalName();
            $image->move(public_path('images/'), $imageName);
            $article->image = $imageName;
        }
        $article->title = $request->title;
        $article->description = $request->description;
        $article->content = $request->content;
        $article->category_id = $request->category_id;
        $article->update();
        $tags = $request->input('tags',[]);
        $article->tags()->sync($tags);
        return new ArticleResource($article); 


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {  
        if($article->user_id!=1){
            return  response()->json(["error"=>'You Dont have permission to make action on this article'], 404);
        }
        $article = Article::find($article->id)->where('user_id',1);
        $article->delete();
        return  response()->json(['success'=>'article deleted successufuly']);
    }
}
