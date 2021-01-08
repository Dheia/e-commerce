<?php namespace Lovata\CampaignsShopaholic\Classes\Event\Product;

use DB;
use Lovata\Toolbox\Classes\Event\ModelHandler;

use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Classes\Item\ProductItem;

use Lovata\CampaignsShopaholic\Models\Campaign;
use Lovata\CampaignsShopaholic\Classes\Store\ProductListStore;

/**
 * Class ProductModelHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\Product
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ProductModelHandler extends ModelHandler
{
    protected $iPriority = 900;

    /** @var Product */
    protected $obElement;

    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);

        Product::extend(function ($obElement) {
            $this->extendModel($obElement);
        });
    }

    /**
     * Extend model object
     * @param Product $obElement
     */
    protected function extendModel($obElement)
    {
        $obElement->belongsToMany['campaign'] = [
            Campaign::class,
            'table' => 'lovata_campaigns_shopaholic_campaign_product',
        ];
    }

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        if ($this->isFieldChanged('active')) {
            $this->clearCachedList();
        }

        if ($this->isFieldChanged('brand_id')) {
            $this->clearProductListByBrandID($this->obElement->brand_id);
            $this->clearProductListByBrandID($this->obElement->getOriginal('brand_id'));
        }

        if ($this->isFieldChanged('category_id')) {
            $this->clearProductListByCategory($this->obElement->category);

            $iOldCategoryID = $this->obElement->getOriginal('category_id');
            //Get old category object
            if (!empty($iOldCategoryID)) {
                $obOldCategory = Category::find($iOldCategoryID);
                $this->clearProductListByCategory($obOldCategory);
            }
        }
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        $this->clearProductListByCategory($this->obElement->category);
        $this->clearProductListByBrandID($this->obElement->brand_id);

        if (!$this->obElement->active) {
            return;
        }

        $this->clearCachedList();
    }

    /**
     * Clear product cached list by campaign ID (Relation between product and campaign)
     */
    protected function clearCachedList()
    {
        //Get campaign list
        $arCampaignIDList = (array) DB::table('lovata_campaigns_shopaholic_campaign_product')->where('product_id', $this->obElement->id)->lists('campaign_id');
        if (empty($arCampaignIDList)) {
            return;
        }

        foreach ($arCampaignIDList as $iCampaignID) {
            ProductListStore::instance()->campaign->clear($iCampaignID);
            ProductListStore::instance()->campaign->clear($iCampaignID, true);
        }
    }

    /**
     * Clear product cached list by campaign ID (Relation between brand and campaign)
     * @param int $iBrandID
     */
    protected function clearProductListByBrandID($iBrandID)
    {
        if (empty($iBrandID)) {
            return;
        }

        //Get campaign list
        $arCampaignIDList = (array) DB::table('lovata_campaigns_shopaholic_campaign_brand')->where('brand_id', $iBrandID)->lists('campaign_id');
        if (empty($arCampaignIDList)) {
            return;
        }

        foreach ($arCampaignIDList as $iCampaignID) {
            ProductListStore::instance()->campaign->clear($iCampaignID);
            ProductListStore::instance()->campaign->clear($iCampaignID, true);
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
