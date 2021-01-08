<?php namespace Wapp\Database\Updates;

use Carbon\Carbon;
use Faker\Factory;
use Lovata\Shopaholic\Models\Price;
use Lovata\Shopaholic\Models\PriceType;
use Lovata\Shopaholic\Models\PromoBlock;
use October\Rain\Database\Updates\Seeder;


class SeederCreatePromoBlock extends Seeder
{

    public function run()
    {
        $factory = Factory::create();
        for ($i = 1; $i < 11; $i++) {
           $promoBlock = PromoBlock::create([
                'active' => '',
                'name' => '',
                'slug' => '',
                'type' => '',
                'code' => '',
                'date_begin' => '',
                'date_end' => '',
                'preview_text' => '',
                'description' => '',
            ]);

//            $promoBlock->product()->create($i);
        }
    }

}
