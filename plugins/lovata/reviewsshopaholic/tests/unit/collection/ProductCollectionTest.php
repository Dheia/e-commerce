<?php namespace Lovata\ReviewsShopaholic\Tests\Unit\Collection;

use Lovata\Shopaholic\Models\Settings;
use Lovata\ReviewsShopaholic\Models\Review;
use Lovata\Toolbox\Tests\CommonTest;

use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Classes\Store\ProductListStore;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;


/**
 * Class ProductCollectionTest
 * @package Lovata\ReviewsShopaholic\Tests\Unit\Collection
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @mixin \PHPUnit\Framework\Assert
 */
class ProductCollectionTest extends CommonTest
{
    /** @var  Product */
    protected $obElement;

    protected $arCreateData = [
        'name'         => 'name',
        'slug'         => 'slug',
        'code'         => 'code',
        'preview_text' => 'preview_text',
        'description'  => 'description',
    ];

    /**
     * Check item collection "sort" method by rating
     */
    public function testSortingByReviews()
    {
        Settings::set('review_activation', true);

        $this->createTestData(1);
        $this->createTestData(2);
        if (empty($this->obElement)) {
            return;
        }

        $sErrorMessage = 'Product collection "sort" method is not correct';

        //Create reviews
        Review::create(['rating' => 2, 'product_id' => $this->obElement->id - 1]);
        Review::create(['rating' => 3, 'product_id' => $this->obElement->id]);

        //Check item collection after create
        $obCollection = ProductCollection::make()->sort(ProductListStore::SORT_RATING_ASC);
        self::assertEquals([$this->obElement->id - 1, $this->obElement->id], array_values($obCollection->getIDList()), $sErrorMessage);

        $obCollection = ProductCollection::make()->sort(ProductListStore::SORT_RATING_DESC);
        self::assertEquals([$this->obElement->id, $this->obElement->id - 1], array_values($obCollection->getIDList()), $sErrorMessage);

        $obReview = Review::create(['rating' => 5, 'product_id' => $this->obElement->id - 1]);

        //Check item collection after create
        $obCollection = ProductCollection::make()->sort(ProductListStore::SORT_RATING_DESC);
        self::assertEquals([$this->obElement->id - 1, $this->obElement->id], array_values($obCollection->getIDList()), $sErrorMessage);

        $obCollection = ProductCollection::make()->sort(ProductListStore::SORT_RATING_ASC);
        self::assertEquals([$this->obElement->id, $this->obElement->id - 1], array_values($obCollection->getIDList()), $sErrorMessage);

        $obReview->delete();

        //Check item collection, after element remove
        $obCollection = ProductCollection::make()->sort(ProductListStore::SORT_RATING_ASC);
        self::assertEquals([$this->obElement->id - 1, $this->obElement->id], array_values($obCollection->getIDList()), $sErrorMessage);

        $obCollection = ProductCollection::make()->sort(ProductListStore::SORT_RATING_DESC);
        self::assertEquals([$this->obElement->id, $this->obElement->id - 1], array_values($obCollection->getIDList()), $sErrorMessage);

        $this->obElement->delete();

        //Check item collection, after element remove
        $obCollection = ProductCollection::make()->sort(ProductListStore::SORT_RATING_ASC);
        self::assertEquals([$this->obElement->id - 1], array_values($obCollection->getIDList()), $sErrorMessage);

        $obCollection = ProductCollection::make()->sort(ProductListStore::SORT_RATING_DESC);
        self::assertEquals([$this->obElement->id - 1], array_values($obCollection->getIDList()), $sErrorMessage);
    }


    /**
     * Create  object for test
     * @param int $iCount
     */
    protected function createTestData($iCount = null)
    {
        //Create product data
        $arCreateData = $this->arCreateData;
        $arCreateData['active'] = true;
        $arCreateData['slug'] = $arCreateData['slug'].$iCount;
        $this->obElement = Product::create($arCreateData);
    }
}