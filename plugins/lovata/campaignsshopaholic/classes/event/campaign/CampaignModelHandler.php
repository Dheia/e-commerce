<?php namespace Lovata\CampaignsShopaholic\Classes\Event\Campaign;

use System\Classes\PluginManager;

use Lovata\Toolbox\Classes\Event\ModelHandler;
use Lovata\CampaignsShopaholic\Models\Campaign;
use Lovata\CampaignsShopaholic\Classes\Item\CampaignItem;
use Lovata\CampaignsShopaholic\Classes\Store\CampaignListStore;
use Lovata\CampaignsShopaholic\Classes\Store\ProductListStore;

/**
 * Class CampaignModelHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\Campaign
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class CampaignModelHandler extends ModelHandler
{
    protected $iPriority = 900;

    /** @var Campaign */
    protected $obElement;

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        parent::afterSave();

        $this->checkFieldChanges('promo_block_id', CampaignListStore::instance()->promo_block);
        $this->checkFieldChanges('active', CampaignListStore::instance()->promo_block);
    }

    /**
     * After delete event handler
     * @throws \Exception
     */
    protected function afterDelete()
    {
        parent::afterDelete();

        CampaignListStore::instance()->promo_block->clear($this->obElement->promo_block_id);

        $this->obElement->brand()->detach();
        $this->obElement->category()->detach();
        $this->obElement->offer()->detach();
        $this->obElement->product()->detach();
        $this->obElement->shipping_type()->detach();

        ProductListStore::instance()->campaign->clear($this->obElement->id);
        ProductListStore::instance()->campaign->clear($this->obElement->id, true);

        if (!PluginManager::instance()->hasPlugin('Lovata.TagsShopaholic')) {
            return;
        }

        $this->obElement->tag()->detach();
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass()
    {
        return Campaign::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return CampaignItem::class;
    }
}
