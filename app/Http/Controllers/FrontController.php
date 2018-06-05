<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Variable;

class FrontController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        $variables = Variable::all();
        return view('front.home', compact('articles', 'variables'));
    }

    public function article(Article $article)
    {
        $variables = Variable::all();


        $image_size = $variables->where('key', 'image-size')->first()->value ?? '';
        
        if(!$image_size){
           abort(500, 'image size error');
        }

       if(!preg_match('/^(\d+)x(\d+)$/', $image_size)){
           abort(500, 'image size error');
       }

       $expSize = explode('x', $image_size);

       $image_size = str_replace('x', '/', $image_size);

        $images = $article->images->pluck('filename')->map(function ($filename) use ($image_size){
            return "<img src=\"../image/$image_size/$filename\">";
        });


        $content = $article->description;

        $replaced = preg_replace_array('/(\[image(|.*?)(|.*?)\])/', $images->toArray(), $content);
        
        return view('front.article', compact('article', 'variables', 'replaced'));
    }
}
