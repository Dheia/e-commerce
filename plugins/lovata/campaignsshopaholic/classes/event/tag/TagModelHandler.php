<?php namespace Lovata\CampaignsShopaholic\Classes\Event\Tag;

use DB;
use System\Classes\PluginManager;
use Lovata\Toolbox\Classes\Event\ModelHandler;

use Lovata\CampaignsShopaholic\Models\Campaign;
use Lovata\CampaignsShopaholic\Classes\Store\ProductListStore;

/**
 * Class TagModelHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\Tag
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class TagModelHandler extends ModelHandler
{
    protected $iPriority = 900;

    /** @var  \Lovata\TagsShopaholic\Models\Tag */
    protected $obElement;

    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        if (!PluginManager::instance()->hasPlugin('Lovata.TagsShopaholic')) {
            return;
        }

        parent::subscribe($obEvent);

        \Lovata\TagsShopaholic\Models\Tag::extend(function ($obElement) {
            $this->extendTagModel($obElement);
        });

        Campaign::extend(function ($obElement) {
            /** @var Campaign $obElement */
            $obElement->belongsToMany['tag'] = [
                \Lovata\TagsShopaholic\Models\Tag::class,
                'table' => 'lovata_campaigns_shopaholic_campaign_tag',
            ];
        });
    }

    /**
     * Extend tag model
     * @param \Lovata\TagsShopaholic\Models\Tag $obElement
     */
    protected function extendTagModel($obElement)
    {
        $obElement->belongsToMany['campaign'] = [
            Campaign::class,
            'table'    => 'lovata_campaigns_shopaholic_campaign_tag',
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

        $this->clearProductList();
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        $this->obElement->campaign()->detach();
    }

    /**
     * Clear product cached list by campaign ID (Relation between tag and campaign)
     */
    protected function clearProductList()
    {
        //Get campaign list
        $arCampaignIDList = (array) DB::table('lovata_campaigns_shopaholic_campaign_tag')->where('tag_id', $this->obElement->id)->lists('campaign_id');
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
        return \Lovata\TagsShopaholic\Models\Tag::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return \Lovata\TagsShopaholic\Classes\Item\TagItem::class;
    }
}
