<?php namespace Lovata\CampaignsShopaholic\Classes\Store;

use Lovata\Toolbox\Classes\Store\AbstractListStore;

use Lovata\CampaignsShopaholic\Classes\Store\ShippingType\ListByCampaignStore;

/**
 * Class ShippingTypeListStore
 * @package Lovata\CampaignsShopaholic\Classes\Store
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @property ListByCampaignStore $campaign
 */
class ShippingTypeListStore extends AbstractListStore
{
    protected static $instance;

    /**
     * Init store method
     */
    protected function init()
    {
        $this->addToStoreList('campaign', ListByCampaignStore::class);
    }
}
