<?php namespace Lovata\ReviewsShopaholic\Classes\Store\Review;

use Lovata\Toolbox\Classes\Store\AbstractStoreWithParam;

use Lovata\ReviewsShopaholic\Models\Review;

/**
 * Class ListByProductStore
 * @package Lovata\ReviewsShopaholic\Classes\Store\Review
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ListByProductStore extends AbstractStoreWithParam
{
    protected static $instance;

    /**
     * Get ID list from database
     * @return array
     */
    protected function getIDListFromDB() : array
    {
        $arElementIDList = (array) Review::getByProduct($this->sValue)->orderBy('id', 'desc')->lists('id');

        return $arElementIDList;
    }
}
