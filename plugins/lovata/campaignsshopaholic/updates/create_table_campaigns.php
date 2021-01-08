<?php namespace Lovata\CampaignsShopaholic\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTableCampaigns
 * @package Lovata\CampaignsShopaholic\Updates
 */
class CreateTableCampaigns extends Migration
{
    const TABLE_NAME = 'lovata_campaigns_shopaholic_campaigns';

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
            $obTable->boolean('active')->default(0);
            $obTable->string('name');
            $obTable->dateTime('date_begin');
            $obTable->dateTime('date_end')->nullable();
            $obTable->integer('promo_mechanism_id')->unsigned();
            $obTable->integer('promo_block_id')->unsigned()->nullable();
            $obTable->text('preview_text')->nullable();
            $obTable->text('description')->nullable();
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
