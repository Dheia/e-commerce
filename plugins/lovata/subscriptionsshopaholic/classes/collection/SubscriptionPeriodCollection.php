<?php namespace Lovata\SubscriptionsShopaholic\Classes\Collection;

use Lovata\Toolbox\Classes\Collection\ElementCollection;

use Lovata\SubscriptionsShopaholic\Classes\Item\SubscriptionPeriodItem;
use Lovata\SubscriptionsShopaholic\Classes\Store\SubscriptionPeriodListStore;

/**
 * Class SubscriptionPeriodCollection
 * @package Lovata\SubscriptionsShopaholic\Classes\Collection
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class SubscriptionPeriodCollection extends ElementCollection
{
    const ITEM_CLASS = SubscriptionPeriodItem::class;

    /**
     * Apply sorting
     * @return $this
     */
    public function sort()
    {
        //Get sorting list
        $arResultIDList = SubscriptionPeriodListStore::instance()->sorting->get();

        return $this->applySorting($arResultIDList);
    }
}
