<?php namespace Wapp\Database\Updates;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use October\Rain\Database\Updates\Seeder;
use RainLab\Blog\Models\Category;
use RainLab\Blog\Models\Post;
use System\Models\File;


class SeederCrateFakeBlog extends Seeder
{

    public function run()
    {
        $factory = Factory::create();

        $categoriesNames = [
            'Обзоры товаров',
            'Советы покупателям',
        ];

        $blog = Category::create([
            'name' => 'Блог',
            'slug' => Str::slug('Блог'),
        ]);

        foreach ($categoriesNames as $key => $categoryName){
            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'parent_id' => $blog->id,
            ]);

            for($i= 1; $i<20; $i++){
                $data = [
                    'published' => $factory->boolean(),
                    'user_id' => 1,
                    'title' => $categoryName.'blog_post'.$i,
                    'slug' => Str::slug($categoryName).'blog_post'.$i,
                    'excerpt' => $factory->realText(100),
                    'content' => $factory->realText(5000) . 'id=' . $i,
                    'published_at' => $factory->dateTimeThisYear(),
                    'year' => $factory->year(),
                ];
                $post = Post::create($data);
                DB::table('rainlab_blog_posts_categories')->insert([
                    'post_id' => $post->id,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
