<?php namespace Lovata\CampaignsShopaholic\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTableCampaignShippingType
 * @package Lovata\CampaignsShopaholic\Updates
 */
class CreateTableCampaignShippingType extends Migration
{
    const TABLE_NAME = 'lovata_campaigns_shopaholic_campaign_shipping_type';

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
            $obTable->integer('shipping_type_id')->unsigned();
            $obTable->integer('campaign_id')->unsigned();

            $obTable->primary(['shipping_type_id', 'campaign_id'], 'shipping_campaign');
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
