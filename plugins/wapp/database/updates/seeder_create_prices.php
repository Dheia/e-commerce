<?php namespace Wapp\Database\Updates;

use Carbon\Carbon;
use Faker\Factory;
use Lovata\Shopaholic\Models\Price;
use Lovata\Shopaholic\Models\PriceType;
use October\Rain\Database\Updates\Seeder;


class SeederCreatePrice extends Seeder
{

    public function run()
    {
        $factory = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            Price::create([
                'item_id' => $factory->numberBetween(1,10),
                'item_type' => 'Lovata\Shopaholic\Models\Offer',
                'price' => $factory->numberBetween(100,2000),
                'old_price' => $factory->numberBetween(100,2000),
                'price_type_id' => $factory->numberBetween(1,3),
            ]);
        }
    }

}
