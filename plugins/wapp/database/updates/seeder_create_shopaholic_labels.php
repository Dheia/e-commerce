<?php namespace Wapp\Database\Updates;

use Lovata\LabelsShopaholic\Models\Label;
use October\Rain\Database\Updates\Seeder;


class SeederCreateShopaholicLabels extends Seeder
{

    public function run()
    {
        Label::create([
            'active' => true,
            'name' => 'new',
            'slug' => 'new',
            'code' => 'new',
            'sort_order' => 1,
        ]);
        Label::create([
            'active' => true,
            'name' => 'hot',
            'slug' => 'hot',
            'code' => 'hot',
            'sort_order' => 2,
        ]);
        Label::create([
            'active' => true,
            'name' => 'sale',
            'slug' => 'sale',
            'code' => 'sale',
            'sort_order' => 3,
        ]);
    }

}
