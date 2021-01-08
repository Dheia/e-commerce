<?php namespace Lovata\ReviewsShopaholic\Classes\Store;

use Lovata\Toolbox\Classes\Store\AbstractListStore;

use Lovata\ReviewsShopaholic\Classes\Store\Review\ActiveListStore;
use Lovata\ReviewsShopaholic\Classes\Store\Review\SortingListStore;
use Lovata\ReviewsShopaholic\Classes\Store\Review\ListByProductStore;

/**
 * Class ReviewListStore
 * @package Lovata\ReviewsShopaholic\Classes\Store
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 * @property ActiveListStore    $active
 * @property SortingListStore   $sorting
 * @property ListByProductStore $product
 */
class ReviewListStore extends AbstractListStore
{
    protected static $instance;

    /**
     * Init store method
     */
    protected function init()
    {
        $this->addToStoreList('sorting', SortingListStore::class);
        $this->addToStoreList('product', ListByProductStore::class);
        $this->addToStoreList('active', ActiveListStore::class);
    }
}
