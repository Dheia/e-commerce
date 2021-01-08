<?php namespace Lovata\AccessoriesShopaholic\Tests\Unit\Item;

use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\Toolbox\Tests\CommonTest;

use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Classes\Item\ProductItem;

/**
 * Class ProductItemTest
 * @package Lovata\AccessoriesShopaholic\Tests\Unit\Item
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @mixin \PHPUnit\Framework\Assert
 */
class ProductItemTest extends CommonTest
{
    /** @var  Product */
    protected $obElement;

    /** @var  Product */
    protected $obAccessoryProduct;

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

        $obAccessoryProductList = $obItem->accessory;
        self::assertInstanceOf(ProductCollection::class, $obAccessoryProductList);
        self::assertEquals(true, $obAccessoryProductList->isEmpty(), $sErrorMessage);

        //Attache product
        $this->obElement->accessory()->attach($this->obAccessoryProduct->id);
        $this->obElement->save();

        //Check item fields
        $obItem = ProductItem::make($this->obElement->id);

        $obAccessoryProductList = $obItem->accessory;
        self::assertEquals(true, $obAccessoryProductList->isNotEmpty(), $sErrorMessage);

        /** @var ProductItem $obAccessoryItem */
        $obAccessoryItem = $obAccessoryProductList->first();
        self::assertEquals($this->obAccessoryProduct->id, $obAccessoryItem->id, $sErrorMessage);

        //Detach product
        $this->obElement->accessory()->detach($this->obAccessoryProduct->id);
        $this->obElement->save();

        //Check item fields
        $obItem = ProductItem::make($this->obElement->id);

        $obAccessoryProductList = $obItem->accessory;
        self::assertEquals(true, $obAccessoryProductList->isEmpty(), $sErrorMessage);
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

        //Create accessory product data
        $arCreateData = $this->arCreateData;
        $arCreateData['active'] = true;
        $arCreateData['slug'] = $arCreateData['slug'].'1';
        $this->obAccessoryProduct = Product::create($arCreateData);
    }
}