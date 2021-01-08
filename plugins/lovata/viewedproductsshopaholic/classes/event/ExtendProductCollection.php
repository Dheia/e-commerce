<?php namespace Lovata\ViewedProductsShopaholic\Classes\Event;

use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\ViewedProductsShopaholic\Classes\Helper\ViewedProductHelper;

/**
 * Class ExtendProductCollection
 * @package Lovata\ViewedProductsShopaholic\Classes\Event
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendProductCollection
{
    /**
     * Add listeners
     */
    public function subscribe()
    {
        ProductCollection::extend(function($obProductList) {
            /** @var ProductCollection $obProductList */
            $this->addViewedProductHelper($obProductList);
        });
    }

    /**
     * Add "viewed" method to collection class
     * @param ProductCollection $obProductList
     */
    protected function addViewedProductHelper($obProductList)
    {
        $obProductList->addDynamicMethod('viewed', function () use ($obProductList) {
            /** @var ViewedProductHelper $obViewed productsHelper */
            $obViewedProductHelper = app(ViewedProductHelper::class);

            $arProductIDList = $obViewedProductHelper->getList();

            return $obProductList->intersect($arProductIDList);
        });
    }
}
