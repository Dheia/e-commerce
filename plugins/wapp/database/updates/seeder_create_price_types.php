<?php namespace Wapp\Database\Updates;

use Carbon\Carbon;
use Faker\Factory;
use Lovata\Shopaholic\Models\PriceType;
use October\Rain\Database\Updates\Seeder;


class SeederCreatePriceTypes extends Seeder
{

    public function run()
    {
        PriceType::create([
            'active' => true,
            'currency_id' => 1,
            'name' => 'priceType1',
            'code' => 'priceType1',
//            'external_id' => '',
        ]);

        PriceType::create([
            'active' => true,
            'currency_id' => 2,
            'name' => 'priceType2',
            'code' => 'priceType2',
//            'external_id' => '',
        ]);

        PriceType::create([
            'active' => true,
            'currency_id' => 3,
            'name' => 'priceType3',
            'code' => 'priceType3',
//            'external_id' => '',
        ]);

    }

}
