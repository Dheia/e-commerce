<?php namespace Lovata\SubscriptionsShopaholic\Classes\Store;

use Lovata\Toolbox\Classes\Store\AbstractListStore;

use Lovata\SubscriptionsShopaholic\Classes\Store\SubscriptionAccess\GetByElementIDListStore;
use Lovata\SubscriptionsShopaholic\Classes\Store\SubscriptionAccess\GetByElementTypeListStore;
use Lovata\SubscriptionsShopaholic\Classes\Store\SubscriptionAccess\GetByProductListStore;
use Lovata\SubscriptionsShopaholic\Classes\Store\SubscriptionAccess\GetByUserListStore;

/**
 * Class SubscriptionAccessListStore
 * @package Lovata\SubscriptionsShopaholic\Classes\Store
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 * @property GetByElementIDListStore   $element_id
 * @property GetByElementTypeListStore $element_type
 * @property GetByProductListStore     $product
 * @property GetByUserListStore        $user
 */
class SubscriptionAccessListStore extends AbstractListStore
{
    protected static $instance;

    /**
     * Init store method
     */
    protected function init()
    {
        $this->addToStoreList('element_id', GetByElementIDListStore::class);
        $this->addToStoreList('element_type', GetByElementTypeListStore::class);
        $this->addToStoreList('product', GetByProductListStore::class);
        $this->addToStoreList('user', GetByUserListStore::class);
    }
}
