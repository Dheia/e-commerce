<?php namespace Lovata\CampaignsShopaholic\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTableCampaignBrand
 * @package Lovata\CampaignsShopaholic\Updates
 */
class CreateTableCampaignBrand extends Migration
{
    const TABLE_NAME = 'lovata_campaigns_shopaholic_campaign_brand';

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
            $obTable->integer('brand_id')->unsigned();
            $obTable->integer('campaign_id')->unsigned();

            $obTable->primary(['brand_id', 'campaign_id'], 'brand_campaign');
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
