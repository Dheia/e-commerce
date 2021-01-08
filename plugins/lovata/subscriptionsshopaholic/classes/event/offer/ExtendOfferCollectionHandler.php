<?php namespace Lovata\SubscriptionsShopaholic\Classes\Event\Offer;

use Lovata\SubscriptionsShopaholic\Classes\Collection\SubscriptionPeriodCollection;
use Lovata\Shopaholic\Classes\Collection\OfferCollection;

/**
 * Class ExtendOfferCollectionHandler
 * @package Lovata\SubscriptionsShopaholic\Classes\Event\Offer
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendOfferCollectionHandler
{
    /**
     * Add listeners
     */
    public function subscribe()
    {
        OfferCollection::extend(function ($obOfferList) {
            $this->addSortByPeriodMethod($obOfferList);
        });
    }

    /**
     * Add sortByPeriod() method to OfferCollection class
     * @param OfferCollection|\Lovata\Shopaholic\Classes\Item\OfferItem[] $obOfferList
     */
    protected function addSortByPeriodMethod($obOfferList)
    {
        $obOfferList->addDynamicMethod('sortByPeriod', function () use ($obOfferList) {
            //Get sorted period list
            $obPeriodList = SubscriptionPeriodCollection::make()->sort();
            $arOfferIDList = [];

            /** @var \Lovata\SubscriptionsShopaholic\Classes\Item\SubscriptionPeriodItem $obPeriodItem */
            foreach ($obPeriodList as $obPeriodItem) {
                foreach ($obOfferList as $obOfferItem) {
                    if ($obOfferItem->subscription_period_id != $obPeriodItem->id) {
                        continue;
                    }

                    $arOfferIDList[] = $obOfferItem->id;
                    break;
                }
            }

            foreach ($obOfferList as $obOfferItem) {
                if (empty($obOfferItem->subscription_period_id)) {
                    $arOfferIDList[] = $obOfferItem->id;
                }
            }

            $obOfferList->applySorting($arOfferIDList);

            return $obOfferList;
        });
    }
}
