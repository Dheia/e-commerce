<?php namespace Lovata\ReviewsShopaholic\Classes\Store\Review;

use Lovata\Toolbox\Classes\Store\AbstractStoreWithoutParam;

use Lovata\ReviewsShopaholic\Models\Review;

/**
 * Class SortingListStore
 * @package Lovata\ReviewsShopaholic\Classes\Store\Review
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class SortingListStore extends AbstractStoreWithoutParam
{
    protected static $instance;

    /**
     * Get ID list from database
     * @return array
     */
    protected function getIDListFromDB() : array
    {
        $arElementIDList = (array) Review::orderBy('id', 'desc')->lists('id');

        return $arElementIDList;
    }
}
