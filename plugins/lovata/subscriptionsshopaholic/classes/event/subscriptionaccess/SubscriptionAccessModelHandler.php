<?php namespace Lovata\SubscriptionsShopaholic\Classes\Event\SubscriptionAccess;

use Lovata\Toolbox\Classes\Event\ModelHandler;

use Lovata\SubscriptionsShopaholic\Models\SubscriptionAccess;
use Lovata\SubscriptionsShopaholic\Classes\Item\SubscriptionAccessItem;
use Lovata\SubscriptionsShopaholic\Classes\Store\SubscriptionAccessListStore;

/**
 * Class SubscriptionAccessModelHandler
 * @package Lovata\SubscriptionsShopaholic\Classes\Event\SubscriptionAccess
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class SubscriptionAccessModelHandler extends ModelHandler
{
    /** @var SubscriptionAccess */
    protected $obElement;

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        $this->checkFieldChanges('user_id', SubscriptionAccessListStore::instance()->user);
        if ($this->isFieldChanged('user_id') || $this->isFieldChanged('product_id')) {
            SubscriptionAccessListStore::instance()->product->clear($this->obElement->product_id);
            SubscriptionAccessListStore::instance()->product->clear($this->obElement->product_id, $this->obElement->user_id);
            SubscriptionAccessListStore::instance()->product->clear($this->obElement->product_id, $this->obElement->getOriginal('user_id'));
            SubscriptionAccessListStore::instance()->product->clear($this->obElement->getOriginal('product_id'));
            SubscriptionAccessListStore::instance()->product->clear($this->obElement->getOriginal('product_id'), $this->obElement->user_id);
            SubscriptionAccessListStore::instance()->product->clear($this->obElement->getOriginal('product_id'), $this->obElement->getOriginal('user_id'));
        }

        if ($this->isFieldChanged('user_id') || $this->isFieldChanged('element_id')) {
            SubscriptionAccessListStore::instance()->element_id->clear($this->obElement->element_id);
            SubscriptionAccessListStore::instance()->element_id->clear($this->obElement->element_id, $this->obElement->user_id);
            SubscriptionAccessListStore::instance()->element_id->clear($this->obElement->element_id, $this->obElement->getOriginal('user_id'));
            SubscriptionAccessListStore::instance()->element_id->clear($this->obElement->getOriginal('element_id'));
            SubscriptionAccessListStore::instance()->element_id->clear($this->obElement->getOriginal('element_id'), $this->obElement->user_id);
            SubscriptionAccessListStore::instance()->element_id->clear($this->obElement->getOriginal('element_id'), $this->obElement->getOriginal('user_id'));
        }

        if ($this->isFieldChanged('user_id') || $this->isFieldChanged('element_type')) {
            SubscriptionAccessListStore::instance()->element_type->clear($this->obElement->element_type);
            SubscriptionAccessListStore::instance()->element_type->clear($this->obElement->element_type, $this->obElement->user_id);
            SubscriptionAccessListStore::instance()->element_type->clear($this->obElement->element_type, $this->obElement->getOriginal('user_id'));
            SubscriptionAccessListStore::instance()->element_type->clear($this->obElement->getOriginal('element_type'));
            SubscriptionAccessListStore::instance()->element_type->clear($this->obElement->getOriginal('element_type'), $this->obElement->user_id);
            SubscriptionAccessListStore::instance()->element_type->clear($this->obElement->getOriginal('element_type'), $this->obElement->getOriginal('user_id'));
        }

        parent::afterSave();
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        SubscriptionAccessListStore::instance()->user->clear($this->obElement->user_id);

        SubscriptionAccessListStore::instance()->product->clear($this->obElement->product_id);
        SubscriptionAccessListStore::instance()->product->clear($this->obElement->product_id, $this->obElement->user_id);

        SubscriptionAccessListStore::instance()->element_id->clear($this->obElement->element_id);
        SubscriptionAccessListStore::instance()->element_id->clear($this->obElement->element_id, $this->obElement->user_id);

        SubscriptionAccessListStore::instance()->element_type->clear($this->obElement->element_type);
        SubscriptionAccessListStore::instance()->element_type->clear($this->obElement->element_type, $this->obElement->user_id);

        parent::afterDelete();
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass()
    {
        return SubscriptionAccess::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return SubscriptionAccessItem::class;
    }
}
