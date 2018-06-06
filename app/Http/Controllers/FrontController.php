<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Variable;
use App\Http\Repositories\ImageRepository;

class FrontController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        $variables = Variable::all();
        return view('front.home', compact('articles', 'variables'));
    }

    public function article(Article $article, ImageRepository $repo)
    {
        $variables = Variable::all();

        $replaced = $repo->mapImages($variables, $article);

        return view('front.article', compact('article', 'variables', 'replaced'));
    }
}
