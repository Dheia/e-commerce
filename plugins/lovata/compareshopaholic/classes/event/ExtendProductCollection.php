<?php namespace Lovata\CompareShopaholic\Classes\Event;

use Lovata\CompareShopaholic\Classes\Helper\CompareHelper;

use Lovata\Shopaholic\Classes\Collection\ProductCollection;

/**
 * Class ExtendProductCollection
 * @package Lovata\CompareShopaholic\Classes\Event
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
            $this->addCompareMethod($obProductList);
        });
    }

    /**
     * Add "compare" method to collection class
     * @param ProductCollection $obProductList
     */
    protected function addCompareMethod($obProductList)
    {
        $obProductList->addDynamicMethod('compare', function () use ($obProductList) {
            /** @var CompareHelper $obCompareHelper */
            $obCompareHelper = app(CompareHelper::class);

            $arProductIDList = $obCompareHelper->getList();

            return $obProductList->intersect($arProductIDList);
        });
    }
}
