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

        $new_images = $article->images;

        $content = $article->description;

        $i = 0;

        $newContent = preg_replace_callback("/\[image\|?(.*?)\]/", function($matches) use ($new_images, $image_size) {
            
            global $i;
            $i++;

            if(isset($new_images[$i-1])) {
                $filename =  $new_images[$i-1]->filename;
                $alt = $matches[1] ?? '';
                $image_url = url('image');
                return "<img src=\"$image_url/$image_size/$filename\" alt=\"$alt\">";
            }
            return '!!! IMAGE NOT FOUND !!!';
            
            
        }, $content);

        $replaced = preg_replace_array('/(\[image(|.*?)(|.*?)\])/', $images->toArray(), $newContent);
        
        return view('front.article', compact('article', 'variables', 'replaced'));
    }
}
