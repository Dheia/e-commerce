<?php namespace Lovata\SubscriptionsShopaholic\Classes\Event\SubscriptionPeriod;

use Lovata\Toolbox\Classes\Event\ModelHandler;

use Lovata\SubscriptionsShopaholic\Models\SubscriptionPeriod;
use Lovata\SubscriptionsShopaholic\Classes\Item\SubscriptionPeriodItem;
use Lovata\SubscriptionsShopaholic\Classes\Store\SubscriptionPeriodListStore;

/**
 * Class SubscriptionPeriodModelHandler
 * @package Lovata\SubscriptionsShopaholic\Classes\Event\SubscriptionPeriod
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class SubscriptionPeriodModelHandler extends ModelHandler
{
    /** @var SubscriptionPeriod */
    protected $obElement;

    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);

        $obEvent->listen('shopaholic.subscription_period.update.sorting', function () {
            $this->clearSortingList();
        });
    }

    /**
     * After create event handler
     */
    protected function afterCreate()
    {
        parent::afterCreate();
        $this->clearSortingList();
    }

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        parent::afterSave();
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        parent::afterDelete();
        $this->clearSortingList();
    }

    /**
     * Clear sorting list
     */
    protected function clearSortingList()
    {
        SubscriptionPeriodListStore::instance()->sorting->clear();
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass()
    {
        return SubscriptionPeriod::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return SubscriptionPeriodItem::class;
    }
}
