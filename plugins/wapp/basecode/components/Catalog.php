<?php namespace Wapp\Basecode\Components;

use Illuminate\Support\Facades\Input;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Lovata\Shopaholic\Classes\Collection\BrandCollection;
use Lovata\Shopaholic\Classes\Collection\CategoryCollection;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\Shopaholic\Models\Category;

class Catalog extends ComponentBase
{
    /** @var null|\Lovata\Shopaholic\Classes\Item\ProductItem */
    protected $obProductItem = null;
    /** @var null|\Lovata\Shopaholic\Classes\Item\CategoryItem */
    protected $obMainCategoryItem = null;
    /** @var null|\Lovata\Shopaholic\Classes\Item\CategoryItem */
    protected $obActiveCategoryItem = null;
    /** @var null|\Lovata\Shopaholic\Classes\Collection\ProductCollection */
    protected $obProductList;
    /** @var null|\Lovata\Shopaholic\Classes\Collection\ProductCollection */
    protected $obFilteredProductList;
    /** @var null|\Lovata\Shopaholic\Classes\Collection\BrandCollection */
    protected $obBrandList;
    protected $sActiveSort;
    protected $iPage;
    /** @var null|\Lovata\FilterShopaholic\Classes\Collection\FilterPropertyCollection */
    protected $obFilterProductPropertyList;
    protected $arFilterPropertyList = [];
    protected $arFilterValueWithoutProperty = [];
    protected $arFilterBrandList = [];
    protected $arFilterCategoryList = [];
    protected $minFilterPrice;
    protected $maxFilterPrice;


    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name' => 'wapp.basecode::lang.component.catalog_title',
            'description' => 'wapp.basecode::lang.component.catalog_description',
        ];
    }

    /**
     * Get active category object
     * @return \Lovata\Shopaholic\Classes\Item\CategoryItem
     */
    public function getActiveCategory()
    {
        return $this->obActiveCategoryItem;
    }

    /**
     * Get product list with filter by active and category
     * @return ProductCollection
     */
    public function getProductList()
    {
        return $this->obProductList;
    }

    /**
     * Get product list with filter by active and category
     * @return BrandCollection
     */
    public function getBrandList()
    {
        return $this->obBrandList;
    }

    /**
     * Get filtered product list with filter by brands and properties
     * @return ProductCollection
     */
    public function getFilteredProductList()
    {
        return $this->obFilteredProductList;
    }

    /**
     * Get brand ID list
     * @return array
     */
    public function getFilterBrandList()
    {
        return $this->arFilterBrandList;
    }

    /**
     * Get category ID list
     * @return array
     */
    public function getFilterCategoryList()
    {
        return $this->arFilterCategoryList;
    }

    /**
     * Get min and max price with filter
     * @return array
     */
    public function getFilterPrice()
    {
        if (empty($this->minFilterPrice)) {
            $this->minFilterPrice = 0;
        }
        if (empty($this->maxFilterPrice)) {
            $this->maxFilterPrice = 0;
        }

        return ['min' => $this->minFilterPrice, 'max' => $this->maxFilterPrice];
    }

    /**
     * Get filter property ID list in request
     * @return array
     */
    public function getFilterPropertyList()
    {
        return $this->arFilterPropertyList;
    }

    /**
     * Get filter property ID list from request
     * @return \Lovata\FilterShopaholic\Classes\Collection\FilterPropertyCollection
     */
    public function getFilterProductPropertyList()
    {
        return $this->obFilterProductPropertyList;
    }

    /**
     * Get filter property list from request
     * @return array
     */
    public function getFilterValueWithoutProperty()
    {
        return $this->arFilterValueWithoutProperty;
    }

    /**
     * Get product list with pagination
     * @param int $iCountPerPage
     * @return array
     */
    public function getProductListWithPagination($iCountPerPage)
    {
        $arProductList = $this->obFilteredProductList->page($this->iPage, $iCountPerPage);
        return $arProductList;
    }

    /**
     * Get breadcrumbs array
     * @return array
     */
    public function getBreadcrumbs()
    {
        $arBreadcrumbs = [];
        if (!empty($this->obProductItem)) {
            $arBreadcrumbs[] = [
                'name' => $this->obProductItem->name,
                'url' => $this->obActiveCategoryItem->getPageUrl('catalog'),
                'active' => true,
            ];
        }

        $obCurrentCategory = $this->obActiveCategoryItem;
        while ($obCurrentCategory->isNotEmpty()) {
            $arBreadcrumbs[] = [
                'name' => $obCurrentCategory->name,
                'url' => $obCurrentCategory->getPageUrl('catalog'),
                'active' => empty($this->obProductItem) && $obCurrentCategory->id == $this->obActiveCategoryItem->id,
            ];

            $obCurrentCategory = $obCurrentCategory->parent;
        }
        $arBreadcrumbs[] = [
            'name' => 'Каталог',
            'url' => Page::url('catalog-tree'),
            'active' => false,
        ];

        $arBreadcrumbs[] = [
            'name' => 'Главная',
            'url' => Page::url('home'),
            'active' => false,
        ];

        $arBreadcrumbs = array_reverse($arBreadcrumbs);

        return $arBreadcrumbs;
    }

    /**
     * Init catalog objects
     * @param string $sActiveSort
     * @param int $iPage
     */
    public function initCatalogData($sActiveSort, $iPage)
    {
        $this->sActiveSort = $sActiveSort;
        $this->iPage = $iPage;

        $this->initFilterCategoryList();
        $this->initFilterWithPrice();
        $this->initProductList();
        $this->initBrandList();
        $this->initFilterPropertyList();
        $this->initFilteredProductList();
    }

    /**
     * @param \Lovata\Shopaholic\Classes\Item\ProductItem $obProductItem
     * @param \Lovata\Shopaholic\Classes\Item\CategoryItem $obMainCategoryItem
     * @param \Lovata\Shopaholic\Classes\Item\CategoryItem $obCategoryItem
     */
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
        $this->obFilterProductPropertyList = $this->obActiveCategoryItem->product_filter_property;
    }

    /**
     * Init product list object
     */
    protected function initProductList()
    {
        $this->obProductList = ProductCollection::make()
            ->active()
            ->sort($this->sActiveSort)
            ->category([$this->obActiveCategoryItem->id], true);

        if (is_array($this->arFilterCategoryList) and !empty($this->arFilterCategoryList)) {
            $this->obProductList = ProductCollection::make()
                ->active()
                ->sort($this->sActiveSort)
                ->category($this->arFilterCategoryList, true);
        }
    }

    /**
     * Init filtered product list object
     */
    protected function initFilteredProductList()
    {
        $this->obFilteredProductList = $this->obProductList->copy();
        if (!empty($this->arFilterBrandList)) {
            $this->obFilteredProductList
                ->filterByBrandList($this->arFilterBrandList);
        }

        if (!empty($this->arFilterPropertyList)) {
            $this->obFilteredProductList
                ->filterByProperty($this->arFilterPropertyList, $this->obFilterProductPropertyList);
        }
        if (!empty($this->maxFilterPrice)) {
            $this->obFilteredProductList
                ->filterByPrice($this->minFilterPrice, $this->maxFilterPrice);
        }
    }


    public function getRangePrice()
    {
        $obRangePrice =
        dd($this->obProductList->getOfferMinPrice()->price, $this->obProductList->getOfferMaxPrice()->price);
    }

    /**
     * Init min and max price with filter
     */
    protected function initFilterWithPrice()
    {
        $sFilter = Input::get('price');
        if (empty($sFilter)) {
            return;
        }
        $arFilterValue = explode('|', $sFilter);
        $this->minFilterPrice = min($arFilterValue);
        $this->maxFilterPrice = max($arFilterValue);
        if (empty($this->minFilterPrice)) {
            $this->minFilterPrice = 0;
        }
    }

    /**
     * Init product list object
     */
    protected function initBrandList()
    {
        $this->obBrandList = BrandCollection::make()
            ->active()
            ->sort()
            ->filterByCategory([$this->obActiveCategoryItem->id]);
        $sFilter = Input::get('brand');
        if (empty($sFilter) || $this->obBrandList->isEmpty()) {
            return;
        }
        $arFilterValue = explode('|', $sFilter);
        /** @var \Lovata\Shopaholic\Classes\Item\BrandItem $obBrandItem */
        foreach ($this->obBrandList as $obBrandItem) {
            if (in_array($obBrandItem->slug, $arFilterValue)) {
                $this->arFilterBrandList[] = $obBrandItem->id;
            }
        }

        return $this->arFilterBrandList;
    }

    /**
     * Init product list object with category
     */
    protected function initFilterCategoryList()
    {
        $obCategoryList = CategoryCollection::make()
            ->active();
        $sFilter = Input::get('category');
        if (empty($sFilter)) {
            return;
        }

        $arFilterValue = explode('|', $sFilter);
        /** @var \Lovata\Shopaholic\Classes\Item\CategoryItem $obCategoryItem */
        foreach ($obCategoryList as $obCategoryItem) {
            if (in_array($obCategoryItem->slug, $arFilterValue)) {
                $this->arFilterCategoryList[] = $obCategoryItem->id;
            }
        }
        return $this->arFilterCategoryList;
    }

    /**
     * Init filter property list
     */
    protected function initFilterPropertyList()
    {
        $this->arFilterPropertyList = Input::get('property');
        $this->arFilterPropertyList = $this->parseRequestValue($this->arFilterPropertyList);

        $arPropertyIDList = $this->obFilterProductPropertyList->getIDList();
        if (empty($arPropertyIDList)) {
            return;
        }

        foreach ($arPropertyIDList as $iPropertyID) {
            $arFilterValueTemp = $this->arFilterPropertyList;
            if (isset($arFilterValueTemp[$iPropertyID])) {
                unset($arFilterValueTemp[$iPropertyID]);
            }

            $this->arFilterValueWithoutProperty[$iPropertyID] = $arFilterValueTemp;
        }
    }

    /**
     * Parse request value
     * @param array $arValueList
     * @return array
     */
    protected function parseRequestValue($arValueList)
    {
        if (empty($arValueList)) {
            return [];
        }
        foreach ($arValueList as $iKey => $sValue) {
            $arValueList[$iKey] = explode('|', $sValue);
        }

        return $arValueList;
    }

}
