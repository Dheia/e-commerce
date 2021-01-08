<?php namespace Lovata\CampaignsShopaholic\Classes\Store;

use Lovata\Toolbox\Classes\Store\AbstractListStore;

use Lovata\CampaignsShopaholic\Classes\Store\Product\ListByCampaignStore;

/**
 * Class ProductListStore
 * @package Lovata\CampaignsShopaholic\Classes\Store
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @property ListByCampaignStore $campaign
 */
class ProductListStore extends AbstractListStore
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
