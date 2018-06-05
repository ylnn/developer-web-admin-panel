<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\ArticleCollection;
use App\Article;
use App\Http\Requests\SaveArticle;
use App\Scopes\ArticleTitleScope;

class ArticleController extends Controller
{
    public function all()
    {
        return new ArticleCollection(Article::all());
    }

    public function create()
    {
        return response()->json(['id' => Article::create()->id]);
    }

    public function edit(Article $article)
    {
        return new ArticleResource($article);
    }

    public function save($id, SaveArticle $request)
    {
        $article= Article::withoutGlobalScope(ArticleTitleScope::class)->findOrFail($id);
        $article->title = $request->title;
        $article->description = $request->description;
        $article->url = $request->url;
        $article->save();
        return new ArticleResource($article);
    }

    public function delete($id)
    {
        Article::withoutGlobalScope(ArticleTitleScope::class)->findOrFail($id)->delete();
        return response()->json(['status' => 'success']);
    }

    public function images(Request $request, $article_id)
    {
        $article = Article::withoutGlobalScope(ArticleTitleScope::class)->find($article_id);
        return $article->images; 
    }

    public function imageSync(Request $request, $article_id)
    {
        $article = Article::withoutGlobalScope(ArticleTitleScope::class)->find($article_id);

        $this->validate($request, [
            'ids' => 'string|nullable'
        ]);

        $ids = $request->ids;

        $array = [];
        if(!empty($ids)){
            $array = explode(',', $ids);
        }

        $article->images()->sync($array);
        return $this->images($request, $article->id);
    }
}
