<?php namespace Lovata\ReviewsShopaholic\Classes\Event;

use Lovata\Toolbox\Classes\Event\ModelHandler;

use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Models\Settings;

use Lovata\ReviewsShopaholic\Plugin;
use Lovata\ReviewsShopaholic\Models\Review;
use Lovata\ReviewsShopaholic\Classes\Item\ReviewItem;
use Lovata\ReviewsShopaholic\Classes\Store\ReviewListStore;

/**
 * Class ReviewModelHandler
 * @package Lovata\ReviewsShopaholic\Classes\Event
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ReviewModelHandler extends ModelHandler
{
    /** @var Product $obProduct */
    protected $obProduct;

    /** @var int */
    protected $iMinRating;

    /** @var int */
    protected $iMaxRating;

    /** @var Review $obElement */
    protected $obElement;

    /**
     * Afret create event handler
     */
    protected function afterCreate()
    {
        parent::afterCreate();

        ReviewListStore::instance()->sorting->clear();
    }

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        parent::afterSave();

        $bUpdateProductRating = $this->obElement->active != $this->obElement->getOriginal('active')
            || $this->obElement->rating != $this->obElement->getOriginal('rating')
            || $this->obElement->product_id != $this->obElement->getOriginal('product_id');

        if ($bUpdateProductRating && $this->obElement->active) {
            $this->addRatingValue($this->obElement->product_id, $this->obElement->rating);
        }

        if ($bUpdateProductRating && $this->obElement->getOriginal('active')) {
            $this->removeRatingValue($this->obElement->getOriginal('product_id'), $this->obElement->getOriginal('rating'));
        }

        $this->checkFieldChanges('product_id', ReviewListStore::instance()->product);
        $this->checkFieldChanges('active', ReviewListStore::instance()->active);
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        parent::afterDelete();

        if ($this->obElement->active) {
            $this->removeRatingValue($this->obElement->product_id, $this->obElement->rating);
        }

        ReviewListStore::instance()->product->clear($this->obElement->product_id);
        ReviewListStore::instance()->sorting->clear();

        if ($this->obElement->active) {
            ReviewListStore::instance()->active->clear();
        }
    }

    /**
     * Add new rating to product and calculate new product rating
     * @param int $iProductID
     * @param int $iRatingValue
     */
    protected function addRatingValue($iProductID, $iRatingValue)
    {
        $this->initRatingData($iProductID);
        $iRatingValue = $this->prepareRatingValue($iRatingValue);
        $this->increase($iRatingValue);
    }

    /**
     * Remove old rating from product and calculate new product rating
     * @param int $iProductID
     * @param int $iRatingValue
     */
    protected function removeRatingValue($iProductID, $iRatingValue)
    {
        $this->initRatingData($iProductID);
        $iRatingValue = $this->prepareRatingValue($iRatingValue);
        $this->decrease($iRatingValue);
    }

    /**
     * Init product data
     * @param int $iProductID
     */
    protected function initRatingData($iProductID)
    {
        $this->iMinRating = (int) Settings::getValue('rating_from', Plugin::DEFAULT_RATING_FROM);
        $this->iMaxRating = (int) Settings::getValue('rating_to', Plugin::DEFAULT_RATING_TO);
        if ($this->iMinRating > $this->iMaxRating) {
            return;
        }

        $this->obProduct = Product::find($iProductID);
        if (empty($this->obProduct)) {
            return;
        }

        //Get product rating data
        $arRatingData = $this->obProduct->rating_data;
        if (empty($arRatingData) || !is_array($arRatingData)) {
            $arRatingData = [];
        }

        for ($iStep = $this->iMinRating; $iStep <= $this->iMaxRating; $iStep++) {
            if (!isset($arRatingData[$iStep])) {
                $arRatingData[$iStep] = 0;
            }
        }

        $this->obProduct->rating_data = $arRatingData;
    }

    /**
     * Prepare rating value
     * @param int $iRatingValue
     * @return int
     */
    protected function prepareRatingValue($iRatingValue)
    {
        $iRatingValue = (int) $iRatingValue;
        if (empty($this->obProduct)) {
            return $iRatingValue;
        }

        if ($this->iMinRating > $iRatingValue) {
            $iRatingValue = $this->iMinRating;
        }

        if ($this->iMaxRating < $iRatingValue) {
            $iRatingValue = $this->iMaxRating;
        }

        return $iRatingValue;
    }

    /**
     * Decrease rating value from product data
     * @param int $iRatingValue
     */
    protected function decrease($iRatingValue)
    {
        if (empty($this->obProduct)) {
            return;
        }

        $arRatingData = $this->obProduct->rating_data;
        $arRatingData[$iRatingValue]--;
        if ($arRatingData[$iRatingValue] < 0) {
            $arRatingData[$iRatingValue] = 0;
        }

        //Set new rating data
        $this->obProduct->rating_data = $arRatingData;
        $this->calculateNewRating();

        $this->obProduct->save();
    }

    /**
     * Increase rating value to product data
     * @param int $iRatingValue
     */
    protected function increase($iRatingValue)
    {
        if (empty($this->obProduct)) {
            return;
        }

        $arRatingData = $this->obProduct->rating_data;
        $arRatingData[$iRatingValue]++;

        //Set new rating data
        $this->obProduct->rating_data = $arRatingData;
        $this->calculateNewRating();

        $this->obProduct->save();
    }

    /**
     * Calculate new rating value
     */
    protected function calculateNewRating()
    {
        if (empty($this->obProduct)) {
            return;
        }

        $arRatingData = $this->obProduct->rating_data;

        //Calculate new rating value
        $iCount = 0;
        $iTotalCount = 0;
        foreach ($arRatingData as $iRating => $iRatingCount) {

            if ($iRating < $this->iMinRating || $iRating > $this->iMaxRating) {
                continue;
            }

            $iCount += $iRatingCount;
            $iTotalCount += $iRating * $iRatingCount;
        }

        if (empty($iCount)) {
            $this->obProduct->rating = 0;
            return;
        }

        $this->obProduct->rating = $iTotalCount / $iCount;
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass()
    {
        return Review::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return ReviewItem::class;
    }
}
