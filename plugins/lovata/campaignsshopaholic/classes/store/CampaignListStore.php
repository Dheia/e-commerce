<?php namespace Lovata\CampaignsShopaholic\Classes\Store;

use Lovata\Toolbox\Classes\Store\AbstractListStore;

use Lovata\CampaignsShopaholic\Classes\Store\Campaign\ListByPromoBlockStore;

/**
 * Class CampaignListStore
 * @package Lovata\CampaignsShopaholic\Classes\Store
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @property ListByPromoBlockStore $promo_block
 */
class CampaignListStore extends AbstractListStore
{
    protected static $instance;

    /**
     * Init store method
     */
    protected function init()
    {
        $this->addToStoreList('promo_block', ListByPromoBlockStore::class);
    }
}
