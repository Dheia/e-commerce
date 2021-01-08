<?php namespace Lovata\ReviewsShopaholic\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTableReviews
 * @package Lovata\ReviewsShopaholic\Updates
 */
class CreateTableReviews extends Migration
{
    /**
     * Apply migration
     */
    public function up()
    {
        if (Schema::hasTable('lovata_reviews_shopaholic_reviews')) {
            return;
        }
        
        Schema::create('lovata_reviews_shopaholic_reviews', function(Blueprint $obTable)
        {
            $obTable->engine = 'InnoDB';
            $obTable->increments('id')->unsigned();
            $obTable->boolean('active')->default(0);
            $obTable->string('name')->nullable();
            $obTable->string('email')->nullable();
            $obTable->string('phone')->nullable();
            $obTable->text('comment')->nullable();
            $obTable->integer('rating')->nullable();
            $obTable->integer('product_id')->unsigned();
            $obTable->timestamps();

            $obTable->index('product_id');
        });
    }

    /**
     * Rollback migration
     */
    public function down()
    {
        Schema::dropIfExists('lovata_reviews_shopaholic_reviews');
    }
}
