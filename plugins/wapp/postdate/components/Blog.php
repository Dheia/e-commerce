<?php namespace Wapp\Postdate\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\DB;
use RainLab\Blog\Models\Category;
use RainLab\Blog\Models\Post;

class Blog extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Extend Blog Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function getAttachedNews($slug)
    {
        $collectionNews = collect();
        $arAttachedNews = Post::get()->where('slug', $slug)->first()->peoples;
        $arAttachedNews = $arAttachedNews ?? [];
        if ($arAttachedNews) {
            foreach ($arAttachedNews as $news) {
                $getNews = Post::get()->where('id', $news['news_id'])->first();
                if ($getNews) {
                    $getNews->url = $this->getUrl($getNews);
                    $collectionNews->add($getNews);
                }
            }
        }

        return $collectionNews;
    }

    public function getUrl($news)
    {
        $getIdCategory = DB::table('rainlab_blog_posts_categories')
            ->where('post_id', $news->id)->first();
        if ($getIdCategory) {
            $getCategory = Category::get()->where('id', $getIdCategory->category_id)->first();
            return $url = $news->slug;
        }
    }
}
