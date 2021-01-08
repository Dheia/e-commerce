<?php namespace Lovata\ReviewsShopaholic\Tests\Unit\Item;

use Lovata\ReviewsShopaholic\Classes\Item\ReviewItem;
use Lovata\ReviewsShopaholic\Models\Review;
use Lovata\Shopaholic\Classes\Item\ProductItem;
use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;
use Lovata\Toolbox\Tests\CommonTest;

/**
 * Class ReviewsItemTest
 * @package Lovata\ReviewsShopaholic\Tests\Unit\Item
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @mixin \PHPUnit\Framework\Assert
 */
class ReviewItemTest extends CommonTest
{
    /** @var  Product */
    protected $obElement;

    /** @var  Offer */
    protected $obOffer;

    /** @var  Review */
    protected $obReview;

    protected $arProductData = [
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
        'name'    => 'name',
        'email'   => 'email',
        'phone'   => 'phone',
        'comment' => 'comment',
        'rating'  => 4,
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

        $sErrorMessage = 'Review item data is not correct';

        $arCreatedData = $this->arReviewData;
        $arCreatedData['id'] = $this->obReview->id;
        $arCreatedData['product_id'] = $this->obReview->product_id;

        //Check item fields
        $obItem = ReviewItem::make($this->obReview->id);
        foreach ($arCreatedData as $sField => $sValue) {
            self::assertEquals($sValue, $obItem->$sField, $sErrorMessage);
        }
        
        $obProductItem = $obItem->product;
        
        self::assertInstanceOf(ProductItem::class, $obProductItem, $sErrorMessage);
        self::assertEquals($this->obElement->id, $obProductItem->id, $sErrorMessage);
    }

    /**
     * Check update cache item data, after update model data
     */
    public function testItemClearCache()
    {
        $this->createTestData();
        if(empty($this->obReview)) {
            return;
        }

        $sErrorMessage = 'Review item data is not correct, after model update';

        $obItem = ReviewItem::make($this->obReview->id);
        self::assertEquals('name', $obItem->name, $sErrorMessage);

        //Check cache update
        $this->obReview->name = 'test';
        $this->obReview->save();

        $obItem = ReviewItem::make($this->obReview->id);
        self::assertEquals('test', $obItem->name, $sErrorMessage);
    }

    /**
     * Check item data, after delete model
     */
    public function testDeleteElement()
    {
        $this->createTestData();
        if(empty($this->obReview)) {
            return;
        }

        $sErrorMessage = 'Review item data is not correct, after model delete';

        $obItem = ReviewItem::make($this->obReview->id);
        self::assertEquals(false, $obItem->isEmpty(), $sErrorMessage);

        //Check active flag in item data
        $this->obReview->delete();

        $obItem = ReviewItem::make($this->obReview->id);
        self::assertEquals(true, $obItem->isEmpty(), $sErrorMessage);
    }

    /**
     * Create test data
     */
    protected function createTestData()
    {
        //Create product data
        $arCreateData = $this->arProductData;
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