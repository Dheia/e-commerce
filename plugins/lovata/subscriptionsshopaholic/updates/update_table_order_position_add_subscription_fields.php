<?php namespace Lovata\SubscriptionsShopaholic\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class UpdateTableOrderPositionAddSubscriptionFields
 * @package Lovata\SubscriptionsShopaholic\Updates
 */
class UpdateTableOrderPositionAddSubscriptionFields extends Migration
{
    const TABLE_NAME = 'lovata_orders_shopaholic_order_positions';

    /**
     * Apply migration
     */
    public function up()
    {
        if (!Schema::hasTable(self::TABLE_NAME) || Schema::hasColumn(self::TABLE_NAME, 'is_subscription')) {
            return;
        }

        Schema::table(self::TABLE_NAME, function (Blueprint $obTable) {
            $obTable->boolean('is_subscription')->default(0);
            $obTable->integer('subscription_access_id')->nullable()->unsigned();
            $obTable->integer('subscription_period_id')->nullable()->unsigned();

            $obTable->index('subscription_access_id', 'subscription_access');
            $obTable->index('subscription_period_id', 'subscription_period');
        });
    }

    /**
     * Rollback migration
     */
    public function down()
    {
        if (!Schema::hasTable(self::TABLE_NAME) || !Schema::hasColumn(self::TABLE_NAME, 'is_subscription')) {
            return;
        }

        Schema::table(self::TABLE_NAME, function (Blueprint $obTable) {
            $obTable->dropColumn(['is_subscription', 'subscription_access_id', 'subscription_period_id']);
        });
    }
}
