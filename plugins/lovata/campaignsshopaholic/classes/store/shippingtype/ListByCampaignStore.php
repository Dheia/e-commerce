<?php namespace Lovata\CampaignsShopaholic\Classes\Store\ShippingType;

use DB;
use Lovata\Toolbox\Classes\Store\AbstractStoreWithParam;

use Lovata\OrdersShopaholic\Classes\Collection\ShippingTypeCollection;

/**
 * Class ListByCampaignStore
 * @package Lovata\CampaignsShopaholic\Classes\Store\ShippingType
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ListByCampaignStore extends AbstractStoreWithParam
{
    protected static $instance;

    /**
     * Get ID list from database
     * @return array
     */
    protected function getIDListFromDB() : array
    {
        $arElementIDList = (array) DB::table('lovata_campaigns_shopaholic_campaign_shipping_type')->where('campaign_id', $this->sValue)->lists('shipping_type_id');
        $arElementIDList = ShippingTypeCollection::make()->active()->intersect($arElementIDList)->getIDList();

        return $arElementIDList;
    }
}
