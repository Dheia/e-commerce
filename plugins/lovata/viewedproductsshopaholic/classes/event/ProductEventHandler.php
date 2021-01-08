<?php namespace Lovata\ViewedProductsShopaholic\Classes\Event;

use Lovata\ViewedProductsShopaholic\Classes\Helper\ViewedProductHelper;

/**
 * Class ProductEventHandler
 * @package Lovata\ViewedProductsShopaholic\Classes\Event
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ProductEventHandler
{
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        $obEvent->listen('shopaholic.product.open', function ($obProduct) {
            /** @var \Lovata\Shopaholic\Models\Product $obProduct */
            /** @var ViewedProductHelper $obViewedProductHelper */
            $obViewedProductHelper = app(ViewedProductHelper::class);
            $obViewedProductHelper->add($obProduct->id);
        });
    }
}
