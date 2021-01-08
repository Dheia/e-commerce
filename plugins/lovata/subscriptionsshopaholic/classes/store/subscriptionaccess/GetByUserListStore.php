<?php namespace Lovata\SubscriptionsShopaholic\Classes\Store\SubscriptionAccess;

use Lovata\Toolbox\Classes\Store\AbstractStoreWithParam;

use Lovata\SubscriptionsShopaholic\Models\SubscriptionAccess;

/**
 * Class GetByUserListStore
 * @package Lovata\SubscriptionsShopaholic\Classes\Store\SubscriptionAccess
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class GetByUserListStore extends AbstractStoreWithParam
{
    protected static $instance;

    /**
     * Get ID list from database
     * @return array
     */
    protected function getIDListFromDB() : array
    {
        $arElementIDList = (array) SubscriptionAccess::getByUser($this->sValue)->orderBy('id', 'desc')->lists('id');

        return $arElementIDList;
    }
}
