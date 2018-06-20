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
        $articles = Article::published(request()->user())->latest()->get();
        $variables = Variable::all();
        $skills = Skill::query()->orderBy('order', 'ASC')->get();
        return view('front.home', compact('articles', 'variables', 'skills'));
    }

    public function article($articleID, ImageRepository $repo)
    {

        // logged in user can see draft record for preview.
        $article = Article::where('id', $articleID)->published(request()->user())->first();

        if($article === null){
            print('not found');
            return;
        }

        $variables = Variable::all();

        $replaced = $repo->mapImages($variables, $article);

        $title = $article->title;
        
        $skills = Skill::query()->orderBy('order', 'ASC')->get();

        return view('front.article', compact('article', 'variables', 'replaced', 'title', 'skills'));
    }
}
