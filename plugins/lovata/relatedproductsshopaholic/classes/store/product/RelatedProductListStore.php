<?php namespace Lovata\RelatedProductsShopaholic\Classes\Store\Product;

use DB;
use Lovata\Toolbox\Classes\Store\AbstractStoreWithParam;

/**
 * Class RelatedProductListStore
 * @package Lovata\RelatedProductsShopaholic\Classes\Store\Product
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class RelatedProductListStore extends AbstractStoreWithParam
{
    protected static $instance;

    /**
     * Get ID list from database
     * @return array
     */
    protected function getIDListFromDB() : array
    {
        $arElementIDList = (array) DB::table('lovata_related_products_shopaholic_link')->where('product_id', $this->sValue)->lists('related_id');

        return $arElementIDList;
    }
}
