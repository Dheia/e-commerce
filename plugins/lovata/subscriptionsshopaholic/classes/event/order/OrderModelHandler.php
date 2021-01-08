<?php namespace Lovata\SubscriptionsShopaholic\Classes\Event\Order;

use Lovata\Toolbox\Classes\Event\ModelHandler;

use Lovata\Shopaholic\Models\Settings;
use Lovata\OrdersShopaholic\Models\Order;
use Lovata\OrdersShopaholic\Classes\Item\OrderItem;
use Lovata\SubscriptionsShopaholic\Classes\Helper\AccessHelper;

/**
 * Class OrderModelHandler
 * @package Lovata\SubscriptionsShopaholic\Classes\Event\Order
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class OrderModelHandler extends ModelHandler
{
    /** @var Order */
    protected $obElement;

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        //Get status from settings
        $iStatusID = Settings::getValue('subscription_order_status');
        if (empty($iStatusID)) {
            return;
        }

        if (!$this->isFieldChanged('status_id') || $this->obElement->status_id != $iStatusID || empty($this->obElement->user_id)) {
            return;
        }

        $this->processOrderPositionList();
    }

    /**
     * After delete event handler
     */
    protected function afterDelete() {}

    /**
     * Process order postions and create access to subscriptions
     */
    protected function processOrderPositionList()
    {
        $obOrderPositionList = $this->obElement->order_position;
        if ($obOrderPositionList->isEmpty()) {
            return;
        }

        foreach ($obOrderPositionList as $obOrderPosition) {
            $obAccessHelper = new AccessHelper($obOrderPosition, $this->obElement->user_id);
            $obAccessHelper->add();
        }
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass()
    {
        return Order::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return OrderItem::class;
    }
}
