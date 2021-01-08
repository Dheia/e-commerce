<?php namespace Lovata\AccessoriesShopaholic\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTableAccessoryLink
 * @package Lovata\AccessoriesShopaholic\Updates
 */
class CreateTableAccessoryLink extends Migration
{
    /**
     * Apply migration
     */
    public function up()
    {
        if (Schema::hasTable('lovata_accessories_shopaholic_link')) {
            return;
        }
        
        Schema::create('lovata_accessories_shopaholic_link', function(Blueprint $obTable)
        {
            $obTable->engine = 'InnoDB';
            $obTable->integer('product_id')->unsigned();
            $obTable->integer('accessory_id')->unsigned();
            $obTable->primary(['product_id', 'accessory_id'], 'accessory_product_link');

            $obTable->index('product_id');
        });
    }

    /**
     * Rollback migration
     */
    public function down()
    {
        Schema::dropIfExists('lovata_accessories_shopaholic_link');
    }
}
