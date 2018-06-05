<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class FrontController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view('front.home', compact('articles'));
    }
    public function article(Article $article)
    {
        return view('front.article', compact('article'));
    }
}
