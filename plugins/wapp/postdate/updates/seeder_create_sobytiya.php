<?php namespace Wapp\Database\Updates;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use October\Rain\Database\Updates\Seeder;
use RainLab\Blog\Models\Category;
use RainLab\Blog\Models\Post;
use System\Models\File;


class SeederCrateSobytiya extends Seeder
{

    public function run()
    {
        $factory = Factory::create();

        $cat = Category::create([
            'name' => 'Соревнования',
            'slug' => Str::slug('Соревнования'),
        ]);

        $calendar = Category::create([
            'name' => 'Календарь соревнований',
            'slug' => Str::slug('Календарь соревнований'),
            'parent_id' => $cat->id,
        ]);

        $rezults = Category::create([
            'name' => 'Результаты соревнований',
            'slug' => Str::slug('Результаты соревнований'),
            'parent_id' => $cat->id,
        ]);

        $resultsOld = Category::create([
            'name' => 'Результаты соревнований до 2011 года',
            'slug' => Str::slug('Результаты соревнований до 2011 года'),
            'parent_id' => $cat->id,
        ]);

        //collegia
        $collegia = Category::create([
            'name' => 'Судейская коллегия',
            'slug' => Str::slug('Судейская коллегия'),
            'parent_id' => $cat->id,
        ]);


        $titles = [
            'Документы и положения',
            'Бланки документов',
            'Протоколы заседания ВКСГС',
            'Программа для судейства соревнований по гребному слалому',
        ];

        foreach ($titles as $key => $title) {
            $category = Category::create([
                'name' => $title,
                'slug' => Str::slug($title),
                'parent_id' => $collegia->id,
            ]);
        }
        //collegia
    }
}
