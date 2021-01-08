<?php namespace Lovata\CampaignsShopaholic\Classes\Event\Offer;

use DB;
use Lovata\Toolbox\Classes\Event\ModelHandler;

use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Settings;
use Lovata\Shopaholic\Classes\Item\OfferItem;

use Lovata\CampaignsShopaholic\Models\Campaign;
use Lovata\CampaignsShopaholic\Classes\Store\OfferListStore;
use Lovata\CampaignsShopaholic\Classes\Store\ProductListStore;

/**
 * Class OfferModelHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\Offer
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class OfferModelHandler extends ModelHandler
{
    protected $iPriority = 900;

    /** @var Offer */
    protected $obElement;

    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);

        Offer::extend(function ($obElement) {
            $this->extendModel($obElement);
        });
    }

    /**
     * Extend model object
     * @param Offer $obElement
     */
    protected function extendModel($obElement)
    {
        $obElement->belongsToMany['campaign'] = [
            Campaign::class,
            'table'    => 'lovata_campaigns_shopaholic_campaign_offer',
        ];
    }

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        if (!$this->isFieldChanged('active') && !$this->isFieldChanged('product_id')) {
            return;
        }

        $this->clearCachedList();
        $this->clearCachedListByProduct($this->obElement->product_id);
        if ($this->isFieldChanged('product_id')) {
            $this->clearCachedListByProduct($this->obElement->getOriginal('product_id'));
        }
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        if (!$this->obElement->active) {
            return;
        }

        $this->clearCachedList();
        $this->clearCachedListByProduct($this->obElement->product_id);
    }

    /**
     * Clear product cached list by campaign ID (Relation between offer and campaign)
     */
    protected function clearCachedList()
    {
        //Get campaign list
        $arCampaignIDList = (array) DB::table('lovata_campaigns_shopaholic_campaign_offer')->where('offer_id', $this->obElement->id)->lists('campaign_id');
        if (empty($arCampaignIDList)) {
            return;
        }

        foreach ($arCampaignIDList as $iCampaignID) {
            ProductListStore::instance()->campaign->clear($iCampaignID);
            ProductListStore::instance()->campaign->clear($iCampaignID, true);
            OfferListStore::instance()->campaign->clear($iCampaignID);
        }
    }

    /**
     * Clear product cached list by campaign ID (Relation between product and campaign)
     * @param int $iProductID
     */
    protected function clearCachedListByProduct($iProductID)
    {
        if (!Settings::getValue('check_offer_active') || empty($iProductID)) {
            return;
        }

        //Get campaign list
        $arCampaignIDList = (array) DB::table('lovata_campaigns_shopaholic_campaign_product')->where('product_id', $iProductID)->lists('campaign_id');
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
        return Offer::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return OfferItem::class;
    }
}
