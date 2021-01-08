<?php namespace Wapp\Basecode\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateUserAddressesTable extends Migration
{
    public function up()
    {
        Schema::table('lovata_orders_shopaholic_user_addresses', function ($table) {
            $table->string('apartment')->nullable();
            $table->boolean('is_favorite')->default(0);
        });
    }

    public function down()
    {
        if (Schema::hasTable('lovata_orders_shopaholic_user_addresses')) {
            Schema::table('lovata_orders_shopaholic_user_addresses', function ($table) {
                $table->dropColumn('apartment');
                $table->dropColumn('is_favorite');
            });
        }
    }
}
