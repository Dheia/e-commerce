<?php namespace Lovata\CampaignsShopaholic\Classes\Event\ShippingType;

use DB;
use Lovata\Toolbox\Classes\Event\ModelHandler;

use Lovata\OrdersShopaholic\Models\ShippingType;
use Lovata\OrdersShopaholic\Classes\Item\ShippingTypeItem;

use Lovata\CampaignsShopaholic\Models\Campaign;
use Lovata\CampaignsShopaholic\Classes\Store\ShippingTypeListStore;

/**
 * Class ShippingTypeModelHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\ShippingType
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ShippingTypeModelHandler extends ModelHandler
{
    protected $iPriority = 900;

    /** @var ShippingType */
    protected $obElement;

    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);

        ShippingType::extend(function ($obElement) {
            $this->extendShippingTypeModel($obElement);
        });
    }

    /**
     * Extend model
     * @param ShippingType $obElement
     */
    protected function extendShippingTypeModel($obElement)
    {
        $obElement->belongsToMany['campaign'] = [
            Campaign::class,
            'table'    => 'lovata_campaigns_shopaholic_campaign_shipping_type',
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

        $this->clearCachedList();
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        $this->obElement->campaign()->detach();
    }

    /**
     * Clear product cached list by campaign ID (Relation between shipping type and campaign)
     */
    protected function clearCachedList()
    {
        //Get campaign list
        $arCampaignIDList = (array) DB::table('lovata_campaigns_shopaholic_campaign_shipping_type')->where('shipping_type_id', $this->obElement->id)->lists('campaign_id');
        if (empty($arCampaignIDList)) {
            return;
        }

        foreach ($arCampaignIDList as $iCampaignID) {
            ShippingTypeListStore::instance()->campaign->clear($iCampaignID);
        }
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass()
    {
        return ShippingType::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return ShippingTypeItem::class;
    }
}
