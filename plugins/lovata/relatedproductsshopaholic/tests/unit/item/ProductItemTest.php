<?php namespace Lovata\RelatedProductsShopaholic\Tests\Unit\Item;

use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\Toolbox\Tests\CommonTest;

use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Classes\Item\ProductItem;

/**
 * Class ProductItemTest
 * @package Lovata\RelatedProductsShopaholic\Tests\Unit\Item
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @mixin \PHPUnit\Framework\Assert
 */
class ProductItemTest extends CommonTest
{
    /** @var  Product */
    protected $obElement;

    /** @var  Product */
    protected $obRelatedProduct;

    protected $arCreateData = [
        'name'         => 'name',
        'slug'         => 'slug',
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

        $obRelatedProductList = $obItem->related;
        self::assertInstanceOf(ProductCollection::class, $obRelatedProductList);
        self::assertEquals(true, $obRelatedProductList->isEmpty(), $sErrorMessage);

        //Attache product
        $this->obElement->related()->attach($this->obRelatedProduct->id);
        $this->obElement->save();

        //Check item fields
        $obItem = ProductItem::make($this->obElement->id);

        $obRelatedProductList = $obItem->related;
        self::assertEquals(true, $obRelatedProductList->isNotEmpty(), $sErrorMessage);

        /** @var ProductItem $obRelatedItem */
        $obRelatedItem = $obRelatedProductList->first();
        self::assertEquals($this->obRelatedProduct->id, $obRelatedItem->id, $sErrorMessage);

        //Detach product
        $this->obElement->related()->detach($this->obRelatedProduct->id);
        $this->obElement->save();

        //Check item fields
        $obItem = ProductItem::make($this->obElement->id);

        $obRelatedProductList = $obItem->related;
        self::assertEquals(true, $obRelatedProductList->isEmpty(), $sErrorMessage);
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

        //Create related product data
        $arCreateData = $this->arCreateData;
        $arCreateData['active'] = true;
        $arCreateData['slug'] = $arCreateData['slug'].'1';
        $this->obRelatedProduct = Product::create($arCreateData);
    }
}