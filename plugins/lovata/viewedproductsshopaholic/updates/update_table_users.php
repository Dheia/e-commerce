<?php namespace Lovata\ViewedProductsShopaholic\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class UpdateTableUsers
 * @package Lovata\ViewedProductsShopaholic\Updates
 */
class UpdateTableUsers extends Migration
{
    /**
     * Apply migration
     */
    public function up()
    {
        if (Schema::hasTable('lovata_buddies_users') && !Schema::hasColumn('lovata_buddies_users', 'viewed_products')) {

            Schema::table('lovata_buddies_users', function (Blueprint $obTable) {
                $obTable->text('viewed_products')->nullable();
            });
        }

        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'viewed_products')) {

            Schema::table('users', function (Blueprint $obTable) {
                $obTable->text('viewed_products')->nullable();
            });
        }
    }

    /**
     * Rollback migration
     */
    public function down()
    {
        if (Schema::hasTable('lovata_buddies_users') && Schema::hasColumn('lovata_buddies_users', 'viewed_products')) {
            Schema::table('lovata_buddies_users', function (Blueprint $obTable) {
                $obTable->dropColumn(['viewed_products']);
            });
        }

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'viewed_products')) {
            Schema::table('users', function (Blueprint $obTable) {
                $obTable->dropColumn(['viewed_products']);
            });
        }
    }
}
