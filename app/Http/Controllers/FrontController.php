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
        return view('front.article', compact('article', 'variables'));
    }
}
