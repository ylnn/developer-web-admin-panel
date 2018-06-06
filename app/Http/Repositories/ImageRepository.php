<?php

namespace App\Http\Repositories;

use App\Article;

class ImageRepository 
{
    public $variables;
    public $article;
    public $imageSize;
    public $newContent;


    public function mapImages($variables, Article $article)
    {
        $this->variables = $variables;
        $this->article = $article;

        $this->getImageSize();

        $this->checkImageSizeExists();

        $this->checkImageSize();

        $this->transformImageSize();

        $this->replaceImages();

        return $this->newContent;

    }
   
    public function getImageSize()
    {
        $this->imageSize = $this->variables->where('key', 'image-size')->first()->value ?? '';
    }

    public function checkImageSizeExists()
    {
        if(!$this->imageSize){
            abort(500, 'image size error');
        }   
    }

    public function checkImageSize()
    {
        if(!preg_match('/^(\d+)x(\d+)$/', $this->imageSize)){
            abort(500, 'image size error');
        }
    }


    public function transformImageSize()
    {
        $expSize = explode('x', $this->imageSize);
        $this->imageSize = str_replace('x', '/', $this->imageSize);   
    }

    public function replaceImages($i = 0)
    {
        $articleImages = $this->article->images;
        $imageSize = $this->imageSize;

        $this->newContent = preg_replace_callback("/\[image\|?(.*?)\]/", function($matches) use ($articleImages, $imageSize) {
            global $i;
            $i++;
            if(isset($articleImages[$i-1])) {
                $filename =  $articleImages[$i-1]->filename;
                $alt = $matches[1] ?? '';
                $image_url = url('image');
                return "<img class=\"img-fluid\" src=\"$image_url/$imageSize/$filename\" alt=\"$alt\">";
            }
            return '!!! IMAGE NOT FOUND !!!';
        }, $this->article->description);   
    }
}
