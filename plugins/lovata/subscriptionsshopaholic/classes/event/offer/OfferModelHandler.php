<?php namespace Lovata\SubscriptionsShopaholic\Classes\Event\Offer;

use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Classes\Item\OfferItem;

use Lovata\SubscriptionsShopaholic\Models\SubscriptionPeriod;
use Lovata\SubscriptionsShopaholic\Classes\Item\SubscriptionPeriodItem;

/**
 * Class OfferModelHandler
 * @package Lovata\SubscriptionsShopaholic\Classes\Event\Offer
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class OfferModelHandler
{
    /**
     * Add listeners
     */
    public function subscribe()
    {
        Offer::extend(function ($obElement) {
            $this->extendOfferModel($obElement);
        });

        OfferItem::extend(function ($obOfferItem) {
            $this->extendOfferItem($obOfferItem);
        });
    }

    /**
     * Extend product model
     * @param Offer $obElement
     */
    protected function extendOfferModel($obElement)
    {
        $obElement->fillable[] = 'subscription_period_id';
        $obElement->addCachedField(['subscription_period_id']);

        $obElement->belongsTo['subscription_period'] = [
            SubscriptionPeriod::class,
            'order' => 'sort_order asc',
        ];
    }

    /**
     * @param OfferItem $obOfferItem
     */
    protected function extendOfferItem($obOfferItem)
    {
        $obOfferItem->arRelationList['subscription_period'] = [
            'class' => SubscriptionPeriodItem::class,
            'field' => 'subscription_period_id',
        ];
    }
}
