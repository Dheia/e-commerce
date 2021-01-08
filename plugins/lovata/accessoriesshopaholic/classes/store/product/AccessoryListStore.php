<?php namespace Lovata\AccessoriesShopaholic\Classes\Store\Product;

use DB;
use Lovata\Toolbox\Classes\Store\AbstractStoreWithParam;

/**
 * Class AccessoryListStore
 * @package Lovata\AccessoriesShopaholic\Classes\Store\Product
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class AccessoryListStore extends AbstractStoreWithParam
{
    protected static $instance;

    /**
     * Get ID list from database
     * @return array
     */
    protected function getIDListFromDB() : array
    {
        $arElementIDList = (array) DB::table('lovata_accessories_shopaholic_link')->where('product_id', $this->sValue)->lists('accessory_id');

        return $arElementIDList;
    }
}
