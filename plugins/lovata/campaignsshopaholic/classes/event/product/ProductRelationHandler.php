<?php namespace Lovata\CampaignsShopaholic\Classes\Event\Product;

use DB;
use Lovata\Toolbox\Classes\Event\AbstractModelRelationHandler;

use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Models\Product;
use Lovata\CampaignsShopaholic\Classes\Store\ProductListStore;

/**
 * Class ProductRelationHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\Product
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ProductRelationHandler extends AbstractModelRelationHandler
{
    protected $iPriority = 900;

    /**
     * After attach event handler
     * @param \Model $obModel
     * @param array $arAttachedIDList
     * @param array $arInsertData
     */
    protected function afterAttach($obModel, $arAttachedIDList, $arInsertData)
    {
        $this->clearProductList($arAttachedIDList);
        $this->checkAdditionalCategoryRelation($arAttachedIDList);
    }

    /**
     * After detach event handler
     * @param \Model $obModel
     * @param array $arAttachedIDList
     */
    protected function afterDetach($obModel, $arAttachedIDList)
    {
        $this->clearProductList($arAttachedIDList);
        $this->checkAdditionalCategoryRelation($arAttachedIDList);
    }

    /**
     * Clear cached product list
     * @param array $arAttachedIDList
     */
    protected function clearProductList($arAttachedIDList)
    {
        if (empty($arAttachedIDList) || $this->sRelationName != 'campaign') {
            return;
        }

        foreach ($arAttachedIDList as $iCampaignID) {
            ProductListStore::instance()->campaign->clear($iCampaignID);
            ProductListStore::instance()->campaign->clear($iCampaignID, true);
        }
    }

    /**
     * Clear cached product list
     * @param array $arAttachedIDList
     */
    protected function checkAdditionalCategoryRelation($arAttachedIDList)
    {
        if (empty($arAttachedIDList) || $this->sRelationName != 'additional_category') {
            return;
        }

        foreach ($arAttachedIDList as $iCategoryID) {
            //Find category object
            $obCategory = Category::find($iCategoryID);
            if (empty($obCategory) || !$obCategory->active) {
                continue;
            }

            $this->clearProductListByCategory($obCategory);
        }
    }

    /**
     * Clear product cached list by campaign ID (Relation between category and campaign)
     * @param \Lovata\Shopaholic\Models\Category $obCategory
     */
    protected function clearProductListByCategory($obCategory)
    {
        if (empty($obCategory)) {
            return;
        }

        //Get campaign list
        $arCampaignIDList = (array) DB::table('lovata_campaigns_shopaholic_campaign_category')->where('category_id', $obCategory->id)->lists('campaign_id');
        if (empty($arCampaignIDList)) {
            return;
        }

        foreach ($arCampaignIDList as $iCampaignID) {
            ProductListStore::instance()->campaign->clear($iCampaignID);
            ProductListStore::instance()->campaign->clear($iCampaignID, true);
        }

        $this->clearProductListByCategory($obCategory->parent);
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass() :string
    {
        return Product::class;
    }

    /**
     * Get relation name
     * @return array
     */
    protected function getRelationName()
    {
        return ['campaign', 'additional_category'];
    }
}
