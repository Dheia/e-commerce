<?php namespace Lovata\SubscriptionsShopaholic\Classes\Item;

use October\Rain\Argon\Argon;
use Lovata\Toolbox\Classes\Helper\UserHelper;
use Lovata\Toolbox\Classes\Item\ElementItem;

use Lovata\Shopaholic\Classes\Item\ProductItem;
use Lovata\OrdersShopaholic\Classes\Collection\OrderPositionCollection;
use Lovata\SubscriptionsShopaholic\Models\SubscriptionAccess;

/**
 * Class SubscriptionAccessItem
 * @package Lovata\SubscriptionsShopaholic\Classes\Item
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @property int                                                                               $id
 * @property int                                                                               $product_id
 * @property int                                                                               $user_id
 * @property \October\Rain\Argon\Argon                                                         $expire_at
 * @property array                                                                             $order_position_id_list
 *
 * @property ProductItem                                                                       $product
 * @property OrderPositionCollection|\Lovata\OrdersShopaholic\Classes\Item\OrderPositionItem[] $order_position
 * @property \Lovata\Buddies\Classes\Item\UserItem                                             $user
 */
class SubscriptionAccessItem extends ElementItem
{
    const MODEL_CLASS = SubscriptionAccess::class;

    /** @var SubscriptionAccess */
    protected $obElement = null;

    public $arRelationList = [
        'product'        => [
            'field' => 'product_id',
            'class' => ProductItem::class,
        ],
        'order_position' => [
            'field' => 'order_position_id_list',
            'class' => OrderPositionCollection::class,
        ],
    ];

    /**
     * Return true, if user has access to subscription
     * @return bool
     */
    public function isActive()
    {
        if ($this->isEmpty()) {
            return false;
        }

        $obExpireDate = $this->expire_at;
        if (empty($obExpireDate)) {
            return true;
        }

        $obDateNow = Argon::now();

        $bResult = $obDateNow->toDateTimeString() <= $obExpireDate->toDateTimeString();

        return $bResult;
    }

    /**
     * @return \Lovata\Buddies\Classes\Item\UserItem|mixed|null
     */
    protected function getUserAttribute()
    {
        $obUser = $this->getAttribute('user');
        if (!empty($obUser)) {
            return $obUser;
        }

        $sPluginName = UserHelper::instance()->getPluginName();
        if ($sPluginName == 'Lovata.Buddies') {
            $obUser = \Lovata\Buddies\Classes\Item\UserItem::make($this->user_id);
        } else {
            $sModelClass = UserHelper::instance()->getUserModel();
            $obUser = $sModelClass::find($this->user_id);
        }

        $this->setAttribute('user', $obUser);

        return $obUser;
    }

    /**
     * Set model data from object
     * @return array
     */
    protected function getElementData()
    {
        $arResult = [
            'order_position_id_list' => $this->obElement->order_position->lists('id'),
        ];

        return $arResult;
    }
}
