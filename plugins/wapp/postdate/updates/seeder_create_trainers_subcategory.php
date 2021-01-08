<?php namespace Wapp\Database\Updates;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use October\Rain\Database\Updates\Seeder;
use RainLab\Blog\Models\Category;
use RainLab\Blog\Models\Post;
use System\Models\File;


class SeederCrateTrainerSubcategory extends Seeder
{

    public function run()
    {
        $category = Category::where('slug','trenerskiy-menedzherskiy-i-rukovodyashchiy-sostav-komandy')->first();
        $categories = [
          'Тренеры',
          'Менеджеры',
          'Медицинский персонал'
        ];
        foreach ($categories as $key => $categoryName){
            $cat = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'parent_id' => $category->id
            ]);
        }
    }
}
