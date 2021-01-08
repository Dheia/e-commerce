<?php namespace Lovata\RelatedProductsShopaholic\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTableRelatedProductLink
 * @package Lovata\RelatedProductsShopaholic\Updates
 */
class CreateTableRelatedProductLink extends Migration
{
    /**
     * Apply migration
     */
    public function up()
    {
        if (Schema::hasTable('lovata_related_products_shopaholic_link')) {
            return;
        }
        
        Schema::create('lovata_related_products_shopaholic_link', function(Blueprint $obTable)
        {
            $obTable->engine = 'InnoDB';
            $obTable->integer('product_id')->unsigned();
            $obTable->integer('related_id')->unsigned();
            $obTable->primary(['product_id', 'related_id'], 'related_product_link');

            $obTable->index('product_id');
        });
    }

    /**
     * Rollback migration
     */
    public function down()
    {
        Schema::dropIfExists('lovata_related_products_shopaholic_link');
    }
}
