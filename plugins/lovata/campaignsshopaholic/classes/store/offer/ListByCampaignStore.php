<?php namespace Lovata\CampaignsShopaholic\Classes\Store\Offer;

use DB;
use Lovata\Toolbox\Classes\Store\AbstractStoreWithParam;

use Lovata\Shopaholic\Classes\Collection\OfferCollection;

/**
 * Class ListByCampaignStore
 * @package Lovata\CampaignsShopaholic\Classes\Store\Offer
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
        $arElementIDList = (array) DB::table('lovata_campaigns_shopaholic_campaign_offer')->where('campaign_id', $this->sValue)->lists('offer_id');
        $arElementIDList = OfferCollection::make()->active()->intersect($arElementIDList)->getIDList();

        return $arElementIDList;
    }
}
