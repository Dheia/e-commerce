<?php namespace Lovata\SubscriptionsShopaholic\Classes\Event\Product;

use Lovata\Shopaholic\Models\Product;

/**
 * Class ProductModelHandler
 * @package Lovata\SubscriptionsShopaholic\Classes\Event\Product
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ProductModelHandler
{
    /**
     * Add listeners
     */
    public function subscribe()
    {
        Product::extend(function ($obElement) {
            $this->extendModel($obElement);
        });
    }

    /**
     * Extend product model
     * @param Product $obElement
     */
    protected function extendModel($obElement)
    {
        $obElement->fillable[] = 'is_subscription';
        $obElement->addCachedField(['is_subscription']);
    }
}
