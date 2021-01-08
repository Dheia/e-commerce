<?php namespace Wapp\BaseCode\Classes\Event\Brand;

use Lovata\Shopaholic\Classes\Item\CategoryItem;
use Lovata\Shopaholic\Classes\Collection\BrandCollection;
use Lovata\Shopaholic\Classes\Store\BrandListStore;

/**
 * Class BrandCollectionHandler
 * @package Lovata\BaseCode\Classes\Event\Brand
 */
class BrandCollectionHandler
{
    protected $arBrandIDList = [];
    protected $arCategoryIDList = [];

    /**
     * Add listeners
     */
    public function subscribe()
    {
        BrandCollection::extend(function ($obBrandList) {
            /** @var BrandCollection $obBrandList */
            $obBrandList->addDynamicMethod('filterByCategory', function ($arCategoryIDList) use ($obBrandList) {
                $this->getCategoryIDList($arCategoryIDList);
                if (empty($this->arCategoryIDList)) {
                    return $obBrandList->clear();
                }

                $this->arCategoryIDList = array_unique($this->arCategoryIDList);
                $this->getBrandIDList();
                if (empty($this->arBrandIDList)) {
                    return $obBrandList->clear();
                }

                $obBrandList->intersect($this->arBrandIDList);

                return $obBrandList->returnThis();
            });
        });
    }

    /**
     * Get brand ID list with filter by category
     * @param int $iCategoryID
     */
    protected function getCategoryIDList($arCategoryIDList)
    {
        if (empty($arCategoryIDList)) {
            return [];
        }

        if (!is_array($arCategoryIDList)) {
            $arCategoryIDList = [$arCategoryIDList];
        }

        foreach ($arCategoryIDList as $iCategoryID) {
            $obCategoryItem = CategoryItem::make($iCategoryID);
            if ($obCategoryItem->isEmpty()) {
                continue;
            }
            $this->arCategoryIDList[] = $obCategoryItem->id;
            if ($obCategoryItem->children->isEmpty()) {
                continue;
            }
            $this->getCategoryIDList($obCategoryItem->children_id_list);
        }
    }

    protected function getBrandIDList()
    {
        if (empty($this->arCategoryIDList)) {
            return;
        }

        foreach ($this->arCategoryIDList as $iCategoryID) {
            $arBrandIDList = BrandListStore::instance()->category->get($iCategoryID);
            $this->arBrandIDList = array_merge($this->arBrandIDList, $arBrandIDList);
        }

        $this->arBrandIDList = array_unique($this->arBrandIDList);
    }

}
