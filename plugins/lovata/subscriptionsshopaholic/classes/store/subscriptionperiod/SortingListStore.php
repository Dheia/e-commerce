<?php namespace Lovata\SubscriptionsShopaholic\Classes\Store\SubscriptionPeriod;

use Lovata\Toolbox\Classes\Store\AbstractStoreWithoutParam;

use Lovata\SubscriptionsShopaholic\Models\SubscriptionPeriod;

/**
 * Class SortingListStore
 * @package Lovata\SubscriptionsShopaholic\Classes\Store\SubscriptionPeriod
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class SortingListStore extends AbstractStoreWithoutParam
{
    protected static $instance;

    /**
     * Get ID list from database
     * @return array
     */
    protected function getIDListFromDB() : array
    {
        $arElementIDList = (array) SubscriptionPeriod::orderBy('sort_order', 'asc')->lists('id');

        return $arElementIDList;
    }
}
