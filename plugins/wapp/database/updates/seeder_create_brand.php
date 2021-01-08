<?php namespace Wapp\Database\Updates;

use Carbon\Carbon;
use Faker\Factory;
use Lovata\Shopaholic\Models\Brand;
use October\Rain\Database\Updates\Seeder;


class SeedAllTable extends Seeder
{

    public function run()
    {
        $factory = Factory::create();
        for ($i = 1; $i < 11; $i++) {
            Brand::create([
                'active' => $factory->boolean(),
                'name' => 'brand ' . $i,
                'slug' => 'brand-' . $i,
                'preview_text' => $factory->text(30) . 'id=' . $i,
                'description' => $factory->text(100) . 'id=' . $i,
            ]);
        }
    }

}
