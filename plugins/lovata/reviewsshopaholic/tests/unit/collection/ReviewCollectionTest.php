<?php namespace Lovata\ReviewsShopaholic\Tests\Unit\Collection;

use Lovata\ReviewsShopaholic\Models\Review;
use Lovata\Toolbox\Tests\CommonTest;

use Lovata\ReviewsShopaholic\Classes\Item\ReviewItem;
use Lovata\ReviewsShopaholic\Classes\Collection\ReviewCollection;

/**
 * Class ReviewCollectionTest
 * @package Lovata\ReviewsShopaholic\Tests\Unit\Collection
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @mixin \PHPUnit\Framework\Assert
 */
class ReviewCollectionTest extends CommonTest
{
    /** @var  Review */
    protected $obElement;

    protected $arCreateData = [
        'active'     => true,
        'name'       => 'name',
        'email'      => 'email',
        'phone'      => 'phone',
        'comment'    => 'comment',
        'rating'     => 4,
        'product_id' => 1,
    ];

    /**
     * Check item collection
     */
    public function testCollectionItem()
    {
        $this->createTestData();
        if (empty($this->obElement)) {
            return;
        }

        $sErrorMessage = 'Review collection item data is not correct';

        //Check item collection
        $obCollection = ReviewCollection::make([$this->obElement->id]);

        /** @var ReviewItem $obItem */
        $obItem = $obCollection->first();
        self::assertInstanceOf(ReviewItem::class, $obItem, $sErrorMessage);
        self::assertEquals($this->obElement->id, $obItem->id, $sErrorMessage);
    }

    /**
     * Check item collection "active" method
     */
    public function testActiveList()
    {
        ReviewCollection::make()->active();

        $this->createTestData();
        if (empty($this->obElement)) {
            return;
        }

        $sErrorMessage = 'Review collection "active" method is not correct';

        //Check item collection after create
        $obCollection = ReviewCollection::make()->active();

        /** @var ReviewItem $obItem */
        $obItem = $obCollection->first();
        self::assertInstanceOf(ReviewItem::class, $obItem, $sErrorMessage);
        self::assertEquals($this->obElement->id, $obItem->id, $sErrorMessage);

        $this->obElement->active = false;
        $this->obElement->save();

        //Check item collection, after active = false
        $obCollection = ReviewCollection::make()->active();
        self::assertEquals(true, $obCollection->isEmpty(), $sErrorMessage);

        $this->obElement->active = true;
        $this->obElement->save();

        //Check item collection, after active = true
        $obCollection = ReviewCollection::make()->active();

        /** @var ReviewItem $obItem */
        $obItem = $obCollection->first();
        self::assertInstanceOf(ReviewItem::class, $obItem, $sErrorMessage);
        self::assertEquals($this->obElement->id, $obItem->id, $sErrorMessage);

        $this->obElement->delete();

        //Check item collection, after element remove
        $obCollection = ReviewCollection::make()->active();
        self::assertEquals(true, $obCollection->isEmpty(), $sErrorMessage);
    }

    /**
     * Check item collection "product" method
     */
    public function testProductFilter()
    {
        $this->createTestData();
        if (empty($this->obElement)) {
            return;
        }

        ReviewCollection::make()->product(1);

        $sErrorMessage = 'Review collection "product" method is not correct';

        //Check item collection after create
        $obCollection = ReviewCollection::make()->product(1);

        /** @var ReviewItem $obItem */
        $obItem = $obCollection->first();
        self::assertInstanceOf(ReviewItem::class, $obItem, $sErrorMessage);
        self::assertEquals($this->obElement->id, $obItem->id, $sErrorMessage);

        $this->obElement->product_id = 2;
        $this->obElement->save();

        //Check item collection, after change product_id field
        $obCollection = ReviewCollection::make()->product(1);
        self::assertEquals(true, $obCollection->isEmpty(), $sErrorMessage);

        $this->obElement->product_id = 1;
        $this->obElement->save();

        //Check item collection, after change product_id field
        $obCollection = ReviewCollection::make()->product(1);

        /** @var ReviewItem $obItem */
        $obItem = $obCollection->first();
        self::assertInstanceOf(ReviewItem::class, $obItem, $sErrorMessage);
        self::assertEquals($this->obElement->id, $obItem->id, $sErrorMessage);

        $this->obElement->delete();

        //Check item collection, after element remove
        $obCollection = ReviewCollection::make()->product(1);
        self::assertEquals(true, $obCollection->isEmpty(), $sErrorMessage);
    }

    /**
     * Check item collection "sort" method
     */
    public function testSortingByID()
    {
        $this->createTestData(1);
        $this->createTestData(2);
        if (empty($this->obElement)) {
            return;
        }

        ReviewCollection::make()->sort();

        $sErrorMessage = 'Review collection "sort" method is not correct';

        //Check item collection after create
        $obCollection = ReviewCollection::make()->sort();
        self::assertEquals([$this->obElement->id, $this->obElement->id - 1], array_values($obCollection->getIDList()), $sErrorMessage);

        $this->obElement->delete();

        //Check item collection, after element remove
        $obCollection = ReviewCollection::make()->sort();
        self::assertEquals([$this->obElement->id - 1], array_values($obCollection->getIDList()), $sErrorMessage);
    }


    /**
     * Create  object for test
     * @param int $iCount
     */
    protected function createTestData($iCount = null)
    {
        //Create review data
        $arCreateData = $this->arCreateData;
        $this->obElement = Review::create($arCreateData);
    }
}