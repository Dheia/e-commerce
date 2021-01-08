<?php namespace Lovata\ReviewsShopaholic\Tests\Unit\Item;

use Lovata\Toolbox\Tests\CommonTest;

use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Classes\Item\ProductItem;

use Lovata\ReviewsShopaholic\Models\Review;
use Lovata\ReviewsShopaholic\Classes\Item\ReviewItem;

/**
 * Class ProductItemTest
 * @package Lovata\ReviewsShopaholic\Tests\Unit\Item
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @mixin \PHPUnit\Framework\Assert
 */
class ProductItemTest extends CommonTest
{
    /** @var  Product */
    protected $obElement;

    /** @var  Offer */
    protected $obOffer;

    /** @var  Review */
    protected $obReview;

    protected $arCreateData = [
        'name'         => 'name',
        'slug'         => 'slug',
        'code'         => 'code',
        'preview_text' => 'preview_text',
        'description'  => 'description',
    ];

    protected $arOfferData = [
        'active'       => true,
        'name'         => 'name',
        'code'         => 'code',
        'preview_text' => 'preview_text',
        'description'  => 'description',
        'price'        => '10,50',
        'old_price'    => '11,50',
        'quantity'     => 5,
    ];

    protected $arReviewData = [
        'active' => true,
        'name'   => 'name',
        'rating' => 4,
    ];

    /**
     * Check item fields
     */
    public function testItemFields()
    {
        $this->createTestData();
        if(empty($this->obElement)) {
            return;
        }

        $sErrorMessage = 'Product item data is not correct';

        //Check item fields
        $obItem = ProductItem::make($this->obElement->id);

        $obReviewList = $obItem->review;
        self::assertEquals(true, $obReviewList->isNotEmpty(), $sErrorMessage);

        /** @var ReviewItem $obReviewItem */
        $obReviewItem = $obReviewList->first();
        self::assertInstanceOf(ReviewItem::class, $obReviewItem);
        self::assertEquals($this->obReview->id, $obReviewItem->id, $sErrorMessage);

        //Check rating values
        self::assertEquals(4, $obItem->rating, $sErrorMessage);
        self::assertEquals([1 => 0, 2 => 0, 3 => 0, 4 => 1, 5 => 0], $obItem->rating_data, $sErrorMessage);

        //Check rating functions
        self::assertEquals(1, $obItem->getRatingCount(4), $sErrorMessage);
        self::assertEquals(0, $obItem->getRatingCount(5), $sErrorMessage);
        self::assertEquals(100, $obItem->getRatingPercent(4), $sErrorMessage);
        self::assertEquals(0, $obItem->getRatingPercent(5), $sErrorMessage);
        self::assertEquals(1, $obItem->getRatingTotalCount(), $sErrorMessage);

        //Create new review
        $arCreateData = $this->arReviewData;
        $arCreateData['product_id'] = $this->obElement->id;
        $arCreateData['rating'] = 5;
        $this->obReview = Review::create($arCreateData);

        $this->obReview->active = true;
        $this->obReview->save();

        //Check item fields
        $obItem = ProductItem::make($this->obElement->id);


        //Check rating values
        self::assertEquals(4.5, $obItem->rating, $sErrorMessage);
        self::assertEquals([1 => 0, 2 => 0, 3 => 0, 4 => 1, 5 => 1], $obItem->rating_data, $sErrorMessage);

        //Check rating functions
        self::assertEquals(1, $obItem->getRatingCount(4), $sErrorMessage);
        self::assertEquals(1, $obItem->getRatingCount(5), $sErrorMessage);
        self::assertEquals(50, $obItem->getRatingPercent(4), $sErrorMessage);
        self::assertEquals(50, $obItem->getRatingPercent(5), $sErrorMessage);
        self::assertEquals(2, $obItem->getRatingTotalCount(), $sErrorMessage);
    }
    
    /**
     * Check item data, after delete model
     */
    public function testDeleteElement()
    {
        $this->createTestData();
        if(empty($this->obElement)) {
            return;
        }

        $sErrorMessage = 'Product item data is not correct, after review delete';

        $obItem = ProductItem::make($this->obElement->id);

        $obReviewList = $obItem->review;
        self::assertEquals(true, $obReviewList->isNotEmpty(), $sErrorMessage);

        /** @var ReviewItem $obReviewItem */
        $obReviewItem = $obReviewList->first();
        self::assertInstanceOf(ReviewItem::class, $obReviewItem);
        self::assertEquals($this->obReview->id, $obReviewItem->id, $sErrorMessage);

        //Remove review
        $this->obReview->delete();

        $obItem = ProductItem::make($this->obElement->id);

        $obReviewList = $obItem->review;
        self::assertEquals(true, $obReviewList->isEmpty(), $sErrorMessage);
    }

    /**
     * Create test data
     */
    protected function createTestData()
    {
        //Create product data
        $arCreateData = $this->arCreateData;
        $arCreateData['active'] = true;
        $this->obElement = Product::create($arCreateData);

        //Create offer data
        $arCreateData = $this->arOfferData;
        $arCreateData['product_id'] = $this->obElement->id;
        $this->obOffer = Offer::create($arCreateData);

        //Create review data
        $arCreateData = $this->arReviewData;
        $arCreateData['product_id'] = $this->obElement->id;
        $this->obReview = Review::create($arCreateData);

        $this->obReview->active = true;
        $this->obReview->save();
    }
}