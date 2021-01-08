<?php namespace Lovata\ViewedProductsShopaholic\Classes\Event;

use Input;
use Lovata\ViewedProductsShopaholic\Classes\Helper\ViewedProductHelper;

use Lovata\Shopaholic\Components\ProductData;
use Lovata\Shopaholic\Components\ProductPage;
use Lovata\Shopaholic\Components\ProductList;

/**
 * Class ExtendProductComponent
 * @package Lovata\ViewedProductsShopaholic\Classes\Event
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
            $this->addMethods();
        });

        ProductData::extend(function ($obComponent) {
            /** @var ProductData $obComponent */
            $this->obComponent = $obComponent;
            $this->addMethods();
        });

        ProductPage::extend(function ($obComponent) {
            /** @var ProductPage $obComponent */
            $this->obComponent = $obComponent;
            $this->addMethods();
        });
    }

    /**
     * Add methods to product component
     */
    protected function addMethods()
    {
        //Add 'remove' method
        $this->obComponent->addDynamicMethod('onRemoveFromViewedProductList', function () {

            $iProductID = Input::get('product_id');

            /** @var ViewedProductHelper $obViewedProductHelper */
            $obViewedProductHelper = app(ViewedProductHelper::class);

            $obViewedProductHelper->remove($iProductID);
            $arProductIDList = $obViewedProductHelper->getList();

            return $arProductIDList;
        });

        //Add 'clear' method
        $this->obComponent->addDynamicMethod('onClearViewedProductList', function () {

            /** @var ViewedProductHelper $obViewedProductHelper */
            $obViewedProductHelper = app(ViewedProductHelper::class);

            $obViewedProductHelper->clear();
        });
    }
}
