<?php namespace Lovata\CampaignsShopaholic\Classes\Store\Campaign;

use Lovata\Toolbox\Classes\Store\AbstractStoreWithParam;

use Lovata\CampaignsShopaholic\Models\Campaign;

/**
 * Class ListByPromoBlockStore
 * @package Lovata\CampaignsShopaholic\Classes\Store\Campaign
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ListByPromoBlockStore extends AbstractStoreWithParam
{
    protected static $instance;

    /**
     * Get ID list from database
     * @return array
     */
    protected function getIDListFromDB() : array
    {
        $arElementIDList = (array) Campaign::active()->getByPromoBlock($this->sValue)->lists('id');

        return $arElementIDList;
    }
}
