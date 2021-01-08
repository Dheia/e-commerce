<?php namespace Lovata\ReviewsShopaholic\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class UpdateTableProduct
 * @package Lovata\ReviewsShopaholic\Updates
 */
class UpdateTableProduct extends Migration
{
    /**
     * Apply migration
     */
    public function up()
    {
        if (!Schema::hasTable('lovata_shopaholic_products') || Schema::hasColumn('lovata_shopaholic_products', 'rating_data')) {
            return;
        }
        
        Schema::table('lovata_shopaholic_products', function(Blueprint $obTable)
        {
            $obTable->text('rating_data')->nullable();
            $obTable->decimal('rating', 5, 2)->nullable();
        });
    }

    /**
     * Rollback migration
     */
    public function down()
    {
        if (!Schema::hasTable('lovata_shopaholic_products') || !Schema::hasColumn('lovata_shopaholic_products', 'rating_data')) {
            return;
        }
        
        Schema::table('lovata_shopaholic_products', function (Blueprint $obTable) {
            $obTable->dropColumn(['rating_data', 'rating']);
        });
    }
}
