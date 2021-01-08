<?php namespace Lovata\SubscriptionsShopaholic\Classes\Store\SubscriptionAccess;

use Lovata\Toolbox\Classes\Store\AbstractStoreWithTwoParam;

use Lovata\SubscriptionsShopaholic\Models\SubscriptionAccess;

/**
 * Class GetByProductListStore
 * @package Lovata\SubscriptionsShopaholic\Classes\Store\SubscriptionAccess
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class GetByProductListStore extends AbstractStoreWithtwoParam
{
    protected static $instance;

    /**
     * Get ID list from database
     * @return array
     */
    protected function getIDListFromDB() : array
    {
        if (empty($this->sAdditionParam)) {
            $arElementIDList = (array) SubscriptionAccess::getByProduct($this->sValue)->orderBy('id', 'desc')->lists('id');
        } else {
            $arElementIDList = (array) SubscriptionAccess::getByUser($this->sAdditionParam)->getByProduct($this->sValue)->orderBy('id', 'desc')->lists('id');
        }

        return $arElementIDList;
    }
}
