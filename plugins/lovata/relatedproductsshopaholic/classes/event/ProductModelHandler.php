<?php namespace Lovata\RelatedProductsShopaholic\Classes\Event;

use Lovata\Toolbox\Classes\Event\ModelHandler;

use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Classes\Item\ProductItem;

use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\RelatedProductsShopaholic\Classes\Store\Product\RelatedProductListStore;

/**
 * Class ProductModelHandler
 * @package Lovata\RelatedProductsShopaholic\Classes\Event
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
    }

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        RelatedProductListStore::instance()->clear($this->obElement->id);
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        RelatedProductListStore::instance()->clear($this->obElement->id);
    }

    /**
     * Extend product model
     * @param Product $obElement
     */
    protected function extendProductModel($obElement)
    {
        $obElement->belongsToMany['related'] = [
            Product::class,
            'table'    => 'lovata_related_products_shopaholic_link',
            'key'      => 'product_id',
            'otherKey' => 'related_id',
        ];
    }

    /**
     * Extend product item
     * @param ProductItem $obItem
     */
    protected function extendProductItem($obItem)
    {
        $obItem->addDynamicMethod('getRelatedAttribute', function ($obItem) {
            /** @var ProductItem $obItem */
            //Get product ID list
            $arProductIDList = RelatedProductListStore::instance()->get($obItem->id);
            $obProductCollection = ProductCollection::make()->intersect($arProductIDList);

            return $obProductCollection;
        });
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
