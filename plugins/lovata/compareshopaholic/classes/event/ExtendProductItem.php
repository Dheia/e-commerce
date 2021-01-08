<?php namespace Lovata\CompareShopaholic\Classes\Event;

use Lovata\Shopaholic\Classes\Item\ProductItem;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;

/**
 * Class ExtendProductItem
 * @package Lovata\CompareShopaholic\Classes\Event
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendProductItem
{
    /**
     * Add listeners
     */
    public function subscribe()
    {
        ProductItem::extend(function($obProductItem) {
            /** @var ProductItem $obProductItem */
            $this->addInCompareMethod($obProductItem);
        });
    }

    /**
     * Add "inCompare" method to Item class
     * @param ProductItem $obProductItem
     */
    protected function addInCompareMethod($obProductItem)
    {
        $obProductItem->addDynamicMethod('inCompare', function () use ($obProductItem) {
            //Get products in compare list
            $obProductList = ProductCollection::make()->compare();

            return $obProductList->has($obProductItem->id);
        });
    }
}
