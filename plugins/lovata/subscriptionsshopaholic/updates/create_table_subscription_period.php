<?php namespace Lovata\SubscriptionsShopaholic\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTableSubscriptionPeriod
 * @package Lovata\SubscriptionsShopaholic\Updates
 */
class CreateTableSubscriptionPeriod extends Migration
{
    const TABLE_NAME = 'lovata_subscription_shopaholic_period';

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
            $obTable->string('name');
            $obTable->string('period');
            $obTable->integer('sort_order')->nullable();
            $obTable->timestamps();
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
