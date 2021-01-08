<?php namespace Lovata\SubscriptionsShopaholic\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTableSubscriptionAccess
 * @package Lovata\SubscriptionsShopaholic\Updates
 */
class CreateTableSubscriptionAccess extends Migration
{
    const TABLE_NAME = 'lovata_subscription_shopaholic_access';

    /**
     * Apply migration
     */
    public function up()
    {
        if (Schema::hasTable(self::TABLE_NAME)) {
            return;
        }

        Schema::create(self::TABLE_NAME, function(Blueprint $obTable)
        {
            $obTable->engine = 'InnoDB';
            $obTable->increments('id')->unsigned();
            $obTable->integer('product_id');
            $obTable->integer('user_id');
            $obTable->dateTime('expire_at')->nullable();
            $obTable->integer('element_id')->nullable();
            $obTable->string('element_type')->nullable();
            $obTable->timestamps();

            $obTable->index('product_id');
            $obTable->index('user_id');
            $obTable->index('element_id');
            $obTable->index('element_type');
        });
    }

    /**
     * Rollback migration
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}
