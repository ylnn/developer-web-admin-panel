<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Variable;
use App\Http\Repositories\ImageRepository;
use App\Skill;

class FrontController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        $variables = Variable::all();
        $skills = Skill::query()->orderBy('order', 'ASC')->get();
        return view('front.home', compact('articles', 'variables', 'skills'));
    }

    public function article(Article $article, ImageRepository $repo)
    {
        $variables = Variable::all();

        $replaced = $repo->mapImages($variables, $article);

        $title = $article->title;
        
        $skills = Skill::query()->orderBy('order', 'ASC')->get();

        return view('front.article', compact('article', 'variables', 'replaced', 'title', 'skills'));
    }
}
