<?php namespace Wapp\Database\Updates;

use Illuminate\Database\Seeder;
use Lovata\Shopaholic\Models\Currency;

/**
 * Class SeederCreateDefaultCurrency
 * @package Lovata\Shopaholic\Updates
 */
class SeederCreateCurrency extends Seeder
{
    /**
     * Run seeder
     */
    public function run()
    {
        $arDefaultCurrencyData = [
            'active' => true,
            'is_default' => false,
            'name' => 'RUB',
            'code' => 'RUB',
            'symbol' => 'rub',
            'rate' => 3.00,
            'sort_order' => 1,
        ];

        Currency::create($arDefaultCurrencyData);


        $arDefaultCurrencyData = [
            'active' => true,
            'is_default' => false,
            'name' => 'UAH',
            'code' => 'UAH',
            'symbol' => 'uah',
            'rate' => 28,
            'sort_order' => 1,
        ];

        Currency::create($arDefaultCurrencyData);

    }
}
