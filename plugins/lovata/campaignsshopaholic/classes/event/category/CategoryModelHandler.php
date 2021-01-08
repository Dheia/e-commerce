<?php namespace Lovata\CampaignsShopaholic\Classes\Event\Category;

use DB;
use Lovata\Toolbox\Classes\Event\ModelHandler;

use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Classes\Item\CategoryItem;

use Lovata\CampaignsShopaholic\Models\Campaign;
use Lovata\CampaignsShopaholic\Classes\Store\ProductListStore;

/**
 * Class CategoryModelHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\Category
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class CategoryModelHandler extends ModelHandler
{
    protected $iPriority = 900;

    /** @var Category */
    protected $obElement;

    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);

        Category::extend(function ($obElement) {
            $this->extendCategoryModel($obElement);
        });

        $obEvent->listen('shopaholic.category.update.sorting', function () {
            $this->clearAllCategories();
        });
    }

    /**
     * Extend model object
     * @param Category $obElement
     */
    protected function extendCategoryModel($obElement)
    {
        $obElement->belongsToMany['campaign'] = [
            Campaign::class,
            'table'    => 'lovata_campaigns_shopaholic_campaign_category',
        ];
    }

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        if (!$this->isFieldChanged('active')) {
            return;
        }

        $this->clearProductList($this->obElement);
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        $this->obElement->campaign()->detach();
        if (!$this->obElement->active) {
            return;
        }

        $this->clearProductList($this->obElement);
    }

    /**
     * Clear product cached list by campaign ID (Relation between category and campaign)
     * @param Category $obCategory
     */
    protected function clearProductList($obCategory)
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

        $this->clearProductList($obCategory->parent);
    }

    /**
     * Clear product cached list by campaign ID (Relation between category and campaign)
     */
    protected function clearAllCategories()
    {
        //Get campaign list
        $arCampaignIDList = (array) DB::table('lovata_campaigns_shopaholic_campaign_category')->groupBy('campaign_id')->lists('campaign_id');
        if (empty($arCampaignIDList)) {
            return;
        }

        foreach ($arCampaignIDList as $iCampaignID) {
            ProductListStore::instance()->campaign->clear($iCampaignID);
            ProductListStore::instance()->campaign->clear($iCampaignID, true);
        }
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass()
    {
        return Category::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return CategoryItem::class;
    }
}
