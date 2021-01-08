<?php namespace Lovata\ReviewsShopaholic\Classes\Store\Review;

use Lovata\Toolbox\Classes\Store\AbstractStoreWithoutParam;

use Lovata\ReviewsShopaholic\Models\Review;

/**
 * Class ActiveListStore
 * @package Lovata\ReviewsShopaholic\Classes\Store\Review
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ActiveListStore extends AbstractStoreWithoutParam
{
    protected static $instance;

    /**
     * Get ID list from database
     * @return array
     */
    protected function getIDListFromDB() : array
    {
        $arElementIDList = (array) Review::active()->lists('id');

        return $arElementIDList;
    }
}
