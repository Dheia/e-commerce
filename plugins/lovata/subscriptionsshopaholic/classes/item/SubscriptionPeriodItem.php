<?php namespace Lovata\SubscriptionsShopaholic\Classes\Item;

use Lovata\Toolbox\Classes\Item\ElementItem;

use Lovata\SubscriptionsShopaholic\Models\SubscriptionPeriod;

/**
 * Class SubscriptionPeriodItem
 * @package Lovata\SubscriptionsShopaholic\Classes\Item
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @property int $id
 * @property string $name
 * @property string $period
 */
class SubscriptionPeriodItem extends ElementItem
{
    const MODEL_CLASS = SubscriptionPeriod::class;

    /** @var SubscriptionPeriod */
    protected $obElement = null;
}
