<?php namespace Lovata\CampaignsShopaholic\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTableCampaignCategory
 * @package Lovata\CampaignsShopaholic\Updates
 */
class CreateTableCampaignCategory extends Migration
{
    const TABLE_NAME = 'lovata_campaigns_shopaholic_campaign_category';

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
            $obTable->integer('category_id')->unsigned();
            $obTable->integer('campaign_id')->unsigned();

            $obTable->primary(['category_id', 'campaign_id'], 'category_campaign');
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
