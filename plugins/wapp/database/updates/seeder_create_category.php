<?php namespace Wapp\Database\Updates;

use Carbon\Carbon;
use Faker\Factory;
use Lovata\Shopaholic\Models\Brand;
use RainLab\Blog\Models\Post;
use October\Rain\Database\Updates\Seeder;
use Lovata\Shopaholic\Models\Category;


class SeederCreateCategory extends Seeder
{

    public function run()
    {
        $factory = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $category = Category::create([
                'active' => true,
                'name' => 'category ' . $i,
                'slug' => 'category-' . $i,
                'description' => 'category-' . $i,
            ]);
            //create child
            Category::create([
                'active' => true,
                'name' => 'category ' . $factory->text(10),
                'slug' => 'category-' . $factory->text(10),
                'description' => 'category-' . $factory->text(40),
                'parent_id' => 1,
            ]);
        }
    }

}
