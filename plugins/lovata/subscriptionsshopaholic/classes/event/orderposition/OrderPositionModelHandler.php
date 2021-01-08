<?php namespace Lovata\SubscriptionsShopaholic\Classes\Event\OrderPosition;

use Lovata\Shopaholic\Models\Offer;
use Lovata\OrdersShopaholic\Models\OrderPosition;
use Lovata\OrdersShopaholic\Classes\Item\OrderPositionItem;

use Lovata\SubscriptionsShopaholic\Classes\Collection\SubscriptionAccessCollection;
use Lovata\SubscriptionsShopaholic\Models\SubscriptionAccess;
use Lovata\SubscriptionsShopaholic\Models\SubscriptionPeriod;
use Lovata\SubscriptionsShopaholic\Classes\Item\SubscriptionAccessItem;
use Lovata\SubscriptionsShopaholic\Classes\Item\SubscriptionPeriodItem;
use October\Rain\Argon\Argon;

/**
 * Class OrderPositionModelHandler
 * @package Lovata\SubscriptionsShopaholic\Classes\Event\OrderPosition
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class OrderPositionModelHandler
{
    protected $iPriority = 1000;

    /**
     * Add listeners
     */
    public function subscribe()
    {
        OrderPosition::extend(function ($obOrderPosition) {
            /** @var OrderPosition $obOrderPosition */
            $obOrderPosition->fillable[] = 'is_subscription';
            $obOrderPosition->fillable[] = 'subscription_access_id';
            $obOrderPosition->fillable[] = 'subscription_period_id';

            $obOrderPosition->addCachedField([
                'is_subscription',
                'subscription_access_id',
                'subscription_period_id',
            ]);

            $obOrderPosition->belongsTo['subscription_access'] = [SubscriptionAccess::class];
            $obOrderPosition->belongsTo['subscription_period'] = [SubscriptionPeriod::class];

            $obOrderPosition->bindEvent('model.beforeCreate', function () use ($obOrderPosition) {
                $this->saveSubscriptionFlag($obOrderPosition);
            }, $this->iPriority);
        });

        OrderPositionItem::extend(function ($obOrderPositionItem) {
            $this->extendItemObject($obOrderPositionItem);
        });
    }

    /**
     * Save subscription flags before create order position
     * @param OrderPosition $obOrderPosition
     */
    protected function saveSubscriptionFlag($obOrderPosition)
    {
        //Get item object
        $obItem = $obOrderPosition->item;
        if (!$obItem instanceof Offer) {
            return;
        }

        //Get product object
        $obProduct = $obItem->product;
        if (empty($obProduct) || !$obProduct->is_subscription) {
            return;
        }

        $obOrderPosition->is_subscription = true;
        $obOrderPosition->subscription_period_id = $obItem->subscription_period_id;
    }

    /**
     * @param OrderPositionItem $obOrderPositionItem
     */
    protected function extendItemObject($obOrderPositionItem)
    {
        $obOrderPositionItem->arRelationList['subscription_access'] = [
            'class' => SubscriptionAccessItem::class,
            'field' => 'subscription_access_id',
        ];
        $obOrderPositionItem->arRelationList['subscription_period'] = [
            'class' => SubscriptionPeriodItem::class,
            'field' => 'subscription_period_id',
        ];

        $obOrderPositionItem->addDynamicMethod('getExpireAtAttribute', function ($obOrderPositionItem) {
            /** @var OrderPositionItem $obOrderPositionItem */
            $iUserID = $obOrderPositionItem->order->user_id;
            $iProductID = $obOrderPositionItem->item->product->id;
            $obPeriodItem = $obOrderPositionItem->subscription_period;
            if ($obPeriodItem->isEmpty() || empty($iProductID)) {
                return null;
            }

            $obAccessItem = SubscriptionAccessCollection::make()->findByProduct($iProductID, $iUserID);
            if ($obAccessItem->isNotEmpty() && !empty($obAccessItem->expire_at)) {
                $obDate = clone $obAccessItem->expire_at;
            } elseif ($obAccessItem->isNotEmpty() && empty($obAccessItem->expire_at)) {
                return null;
            } else {
                $obDate = Argon::now();
            }

            $obDate->add($obPeriodItem->period);

            return $obDate;
        });
    }
}
