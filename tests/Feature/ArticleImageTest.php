<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Article;

class ArticleImageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_is_image_show_in_article_detail_page()
    {
        $article = Article::find(12);
        $response = $this->get('/article/'.$article->id);

        //test [image] tag is in body
        $this->assertRegExp('/\[image.*?\]/', $article->description);

        $content = $response->getContent();
        //check image in content!
        $this->assertRegExp('/test\/image.*?\.jpeg/', $content);

        $response->assertStatus(200);

    }
}
