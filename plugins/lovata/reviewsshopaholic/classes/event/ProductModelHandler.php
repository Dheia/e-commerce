<?php namespace Lovata\ReviewsShopaholic\Classes\Event;

use Lovata\Toolbox\Classes\Event\ModelHandler;

use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Classes\Item\ProductItem;
use Lovata\Shopaholic\Classes\Store\ProductListStore;

use Lovata\ReviewsShopaholic\Models\Review;
use Lovata\ReviewsShopaholic\Classes\Collection\ReviewCollection;

/**
 * Class ProductModelHandler
 * @package Lovata\ReviewsShopaholic\Classes\Event
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ProductModelHandler extends ModelHandler
{
    /** @var  Product */
    protected $obElement;

    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);

        Product::extend(function ($obElement) {
            $this->extendProductModel($obElement);
        });

        ProductItem::extend(function ($obItem) {
            $this->extendProductItem($obItem);
        });

        $obEvent->listen('shopaholic.sorting.get.list', function ($sSorting) {
            return $this->getSortingList($sSorting);
        });
    }


    /**
     * After save event handler
     */
    protected function afterSave()
    {
        //Check "rating" field
        if ($this->obElement->getOriginal('rating') == $this->obElement->rating) {
            return;
        }

        //Update product list with rating
        ProductListStore::instance()->sorting->clear(ProductListStore::SORT_RATING_DESC);
        ProductListStore::instance()->sorting->clear(ProductListStore::SORT_RATING_ASC);
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        //Update product list with rating
        ProductListStore::instance()->sorting->clear(ProductListStore::SORT_RATING_DESC);
        ProductListStore::instance()->sorting->clear(ProductListStore::SORT_RATING_ASC);
    }

    /**
     * Extend product model
     * @param Product $obElement
     */
    protected function extendProductModel($obElement)
    {
        $obElement->hasMany['review'] = [
            Review::class,
            'table' => 'lovata_reviews_shopaholic_reviews',
        ];

        $obElement->addJsonable(['rating_data']);
        $obElement->fillable[] = 'rating';
        $obElement->fillable[] = 'rating_data';

        $obElement->addCachedField([
            'rating',
            'rating_data',
        ]);
    }

    /**
     * Extend product item
     * @param ProductItem $obItem
     */
    protected function extendProductItem($obItem)
    {
        $obItem->addDynamicMethod('getReviewAttribute', function ($obItem) {
            /** @var ProductItem $obItem */
            $obReviewCollection = ReviewCollection::make()->product($obItem->id);

            return $obReviewCollection;
        });

        $obItem->addDynamicMethod('getRatingCount', function ($iRating) use ($obItem) {
            /** @var Product $obProduct */
            $arRatingData = $obItem->rating_data;
            if (empty($arRatingData) || !is_array($arRatingData) || !isset($arRatingData[$iRating])) {
                return 0;
            }

            $iCount = $arRatingData[$iRating];

            return $iCount;
        });

        $obItem->addDynamicMethod('getRatingTotalCount', function () use ($obItem) {
            /** @var Product $obProduct */
            $arRatingData = $obItem->rating_data;
            if (empty($arRatingData) || !is_array($arRatingData)) {
                return 0;
            }

            $iCount = 0;
            foreach ($arRatingData as $iRating => $iRatingCount) {
                $iCount += $iRatingCount;
            }

            return $iCount;
        });

        $obItem->addDynamicMethod('getRatingPercent', function ($iRating) use ($obItem) {
            /** @var Product $obProduct */
            $iCount = $obItem->getRatingCount($iRating);
            $iTotalCount = $obItem->getRatingTotalCount();
            if ($iTotalCount == 0) {
                return 0;
            }

            $fPercent = ($iCount / $iTotalCount) * 100;

            return $fPercent;
        });
    }

    /**
     * Get sorting by popularity
     * @param string $sSorting
     * @return array|null
     */
    protected function getSortingList($sSorting)
    {
        if ($sSorting == ProductListStore::SORT_RATING_DESC) {

            /** @var array $arProductIDList */
            $arProductIDList = Product::orderBy('rating', 'desc')->lists('id');

            return $arProductIDList;
        } elseif ($sSorting == ProductListStore::SORT_RATING_ASC) {

            /** @var array $arProductIDList */
            $arProductIDList = Product::orderBy('rating', 'asc')->lists('id');

            return $arProductIDList;
        }

        return null;
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass()
    {
        return Product::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return ProductItem::class;
    }
}
