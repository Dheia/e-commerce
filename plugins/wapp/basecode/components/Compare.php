<?php namespace Wapp\Basecode\Components;

use Illuminate\Support\Facades\Input;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Lovata\Shopaholic\Classes\Collection\BrandCollection;
use Lovata\Shopaholic\Classes\Collection\CategoryCollection;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\Shopaholic\Models\Category;

class Compare extends Catalog
{
    /** @var null|\Lovata\Shopaholic\Classes\Item\ProductItem */
    protected $obProductItem = null;
    /** @var null|\Lovata\Shopaholic\Classes\Item\CategoryItem */
    protected $obMainCategoryItem = null;
    /** @var null|\Lovata\Shopaholic\Classes\Item\CategoryItem */
    protected $obActiveCategoryItem = null;
    /** @var null|\Lovata\Shopaholic\Classes\Collection\ProductCollection */
    protected $obProductList;
    /** @var null|\Lovata\Shopaholic\Classes\Collection\BrandCollection */
    protected $sActiveSort;
    /** @var null|\Lovata\FilterShopaholic\Classes\Collection\FilterPropertyCollection */
    protected $obFilterProductPropertyList;
    protected $arFilterCategoryList = [];


    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name' => 'wapp.basecode::lang.component.compare_title',
            'description' => 'wapp.basecode::lang.component.compare_description',
        ];
    }

    public function setRequestData($obProductItem, $obMainCategoryItem, $obCategoryItem)
    {
        $this->obProductItem = $obProductItem;
        $this->obMainCategoryItem = $obMainCategoryItem;

        $this->obActiveCategoryItem = $obMainCategoryItem;

        if (!empty($obCategoryItem)) {
            $this->obActiveCategoryItem = $obCategoryItem;
        } elseif ($this->obProductItem) {
            $this->obActiveCategoryItem = $this->obProductItem->category;
        }

        if ($this->obProductItem) {
            $this->obCategoryItem = $this->obProductItem->category;
        }
        if ($this->obActiveCategoryItem) {
            $this->obFilterProductPropertyList = $this->obActiveCategoryItem->product_filter_property;
        }
    }

    /**
     * Init compare objects
     * @param string $sActiveSort
     */
    public function initCompareData($sActiveSort)
    {
        $this->sActiveSort = $sActiveSort;
    }

    /**
     * get product collection with compare
     * @return object $obProductList
     */
    public function getSortWithCategory()
    {
        if ($this->obActiveCategoryItem != null) {
            $this->obProductList = ProductCollection::make()
                ->active()
                ->sort($this->sActiveSort)
                ->category([$this->obActiveCategoryItem->id], true);
        } else {
            $this->obProductList = ProductCollection::make()
                ->active()
                ->sort($this->sActiveSort)
                ->category(null, true);
        }

        if (is_array($this->arFilterCategoryList) and !empty($this->arFilterCategoryList)) {
            $this->obProductList = ProductCollection::make()
                ->active()
                ->sort($this->sActiveSort)
                ->category($this->arFilterCategoryList, true);
        }
        $obProductList = $this->obProductList->copy();
        return $obProductList->compare();
    }
}
