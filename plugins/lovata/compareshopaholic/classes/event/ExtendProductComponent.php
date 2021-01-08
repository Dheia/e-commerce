<?php namespace Lovata\CompareShopaholic\Classes\Event;

use Input;
use Lovata\CompareShopaholic\Classes\Helper\CompareHelper;

use Lovata\Shopaholic\Components\ProductData;
use Lovata\Shopaholic\Components\ProductPage;
use Lovata\Shopaholic\Components\ProductList;

/**
 * Class ExtendProductComponent
 * @package Lovata\CompareShopaholic\Classes\Event
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendProductComponent
{
    /** @var ProductList|ProductPage|ProductData */
    protected $obComponent;

    /**
     * Add listeners
     */
    public function subscribe()
    {
        ProductList::extend(function ($obComponent) {
            /** @var ProductList $obComponent */
            $this->obComponent = $obComponent;
            $this->addCompareMethods();
        });

        ProductData::extend(function ($obComponent) {
            /** @var ProductData $obComponent */
            $this->obComponent = $obComponent;
            $this->addCompareMethods();
        });

        ProductPage::extend(function ($obComponent) {
            /** @var ProductPage $obComponent */
            $this->obComponent = $obComponent;
            $this->addCompareMethods();
        });
    }

    /**
     * Add compare methods to product component
     */
    protected function addCompareMethods()
    {
        //Add 'add' method
        $this->obComponent->addDynamicMethod('onAddToCompare', function () {

            $iProductID = Input::get('product_id');

            /** @var CompareHelper $obCompareHelper */
            $obCompareHelper = app(CompareHelper::class);

            $obCompareHelper->add($iProductID);
            $arProductIDList = $obCompareHelper->getList();

            return $arProductIDList;
        });

        //Add 'remove' method
        $this->obComponent->addDynamicMethod('onRemoveFromCompare', function () {

            $iProductID = Input::get('product_id');

            /** @var CompareHelper $obCompareHelper */
            $obCompareHelper = app(CompareHelper::class);

            $obCompareHelper->remove($iProductID);
            $arProductIDList = $obCompareHelper->getList();

            return $arProductIDList;
        });

        //Add 'clear' method
        $this->obComponent->addDynamicMethod('onClearCompareList', function () {

            /** @var CompareHelper $obCompareHelper */
            $obCompareHelper = app(CompareHelper::class);

            $obCompareHelper->clear();
        });
    }
}
