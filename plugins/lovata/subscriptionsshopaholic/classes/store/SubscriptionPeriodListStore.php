<?php namespace Lovata\SubscriptionsShopaholic\Classes\Store;

use Lovata\Toolbox\Classes\Store\AbstractListStore;

use Lovata\SubscriptionsShopaholic\Classes\Store\SubscriptionPeriod\SortingListStore;

/**
 * Class SubscriptionPeriodListStore
 * @package Lovata\SubscriptionsShopaholic\Classes\Store
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 * @property SortingListStore    $sorting
 */
class SubscriptionPeriodListStore extends AbstractListStore
{
    protected static $instance;

    /**
     * Init store method
     */
    protected function init()
    {
        $this->addToStoreList('sorting', SortingListStore::class);
    }
}
