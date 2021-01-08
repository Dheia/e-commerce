<?php namespace Lovata\CampaignsShopaholic\Classes\Event\Brand;

use DB;
use Lovata\Toolbox\Classes\Event\ModelHandler;

use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Classes\Item\BrandItem;

use Lovata\CampaignsShopaholic\Models\Campaign;
use Lovata\CampaignsShopaholic\Classes\Store\ProductListStore;

/**
 * Class BrandModelHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\Brand
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class BrandModelHandler extends ModelHandler
{
    protected $iPriority = 900;

    /** @var Brand */
    protected $obElement;

    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);

        Brand::extend(function ($obElement) {
            $this->extendBrandModel($obElement);
        });
    }

    /**
     * Extend brand model
     * @param Brand $obElement
     */
    protected function extendBrandModel($obElement)
    {
        $obElement->belongsToMany['campaign'] = [
            Campaign::class,
            'table'    => 'lovata_campaigns_shopaholic_campaign_brand',
        ];
    }

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        if (!$this->isFieldChanged('active')) {
            return;
        }

        $this->clearProductList();
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        $this->obElement->campaign()->detach();
    }

    /**
     * Clear product cached list by campaign ID (Relation between brand and campaign)
     */
    protected function clearProductList()
    {
        //Get campaign list
        $arCampaignIDList = (array) DB::table('lovata_campaigns_shopaholic_campaign_brand')->where('brand_id', $this->obElement->id)->lists('campaign_id');
        if (empty($arCampaignIDList)) {
            return;
        }

        foreach ($arCampaignIDList as $iCampaignID) {
            ProductListStore::instance()->campaign->clear($iCampaignID);
            ProductListStore::instance()->campaign->clear($iCampaignID, true);
        }
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass()
    {
        return Brand::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return BrandItem::class;
    }
}
