<?php namespace Wapp\Database\Updates;

use Carbon\Carbon;
use Faker\Factory;
use Lovata\Shopaholic\Models\PriceType;
use Lovata\Shopaholic\Models\Product;
use October\Rain\Database\Updates\Seeder;


class SeederCreate0Products extends Seeder
{

    public function run()
    {
        $factory = Factory::create();
        for ($i = 1; $i < 11; $i++) {
            Product::create([
                'active' => $factory->boolean(),
                'name' => 'product ' . $i,
                'slug' => 'product-' . $i,
                'brand_id' => $factory->numberBetween($min = 1, $max = 10),
                'category_id' => $factory->numberBetween($min = 1, $max = 10),
                'external_id' => '',
                'code' => $factory->text(6),
                'preview_text' => $factory->text(60),
                'description' => $factory->text(300),
            ]);
        }
    }

}
