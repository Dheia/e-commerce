<?php namespace Lovata\ReviewsShopaholic\Classes\Collection;

use Lovata\Toolbox\Classes\Collection\ElementCollection;

use Lovata\ReviewsShopaholic\Classes\Item\ReviewItem;
use Lovata\ReviewsShopaholic\Classes\Store\ReviewListStore;

/**
 * Class ReviewCollection
 * @package Lovata\ReviewsShopaholic\Classes\Collection
 */
class ReviewCollection extends ElementCollection
{
    const ITEM_CLASS = ReviewItem::class;

    /**
     * Sort list
     * @return $this
     */
    public function sort()
    {
        //Get sorting list
        $arElementIDList = ReviewListStore::instance()->sorting->get();

        return $this->applySorting($arElementIDList);
    }

    /**
     * Apply filter by active element list
     * @return $this
     */
    public function active()
    {
        $arElementIDList = ReviewListStore::instance()->active->get();

        return $this->intersect($arElementIDList);
    }

    /**
     * Apply filter by product ID
     * @param int $iProductID
     * @return $this
     */
    public function product($iProductID)
    {
        $arElementIDList = ReviewListStore::instance()->product->get($iProductID);

        return $this->intersect($arElementIDList);
    }
}
