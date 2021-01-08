<?php namespace Lovata\CampaignsShopaholic\Classes\Event\PromoBlock;

use Lovata\Toolbox\Classes\Event\ModelHandler;

use Lovata\Shopaholic\Models\PromoBlock;
use Lovata\Shopaholic\Classes\Item\PromoBlockItem;

use Lovata\CampaignsShopaholic\Models\Campaign;
use Lovata\CampaignsShopaholic\Classes\Store\CampaignListStore;
use Lovata\CampaignsShopaholic\Classes\Collection\CampaignCollection;

/**
 * Class PromoBlockModelHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\PromoBlock
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class PromoBlockModelHandler extends ModelHandler
{
    /** @var PromoBlock */
    protected $obElement;

    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);

        PromoBlock::extend(function ($obElement) {
            $this->extendPromoBlockModel($obElement);
        });

        $obEvent->listen(PromoBlock::EVENT_GET_PRODUCT_LIST, function ($iPromoBlockID) {
            return $this->getProductIDList($iPromoBlockID);
        });
    }

    /**
     * Extend model
     * @param PromoBlock $obElement
     */
    protected function extendPromoBlockModel($obElement)
    {
        $obElement->hasMany['campaign'] = [Campaign::class];
    }

    /**
     * Get product ID list by relation between promo block and campaigns
     * @param int $iPromoBlockID
     * @return array
     */
    protected function getProductIDList($iPromoBlockID) : array
    {
        $obCampaignList = CampaignCollection::make()->promoBlock($iPromoBlockID);
        if ($obCampaignList->isEmpty()) {
            return [];
        }

        $arResult = [];
        /** @var \Lovata\CampaignsShopaholic\Classes\Item\CampaignItem $obCampaignItem */
        foreach ($obCampaignList as $obCampaignItem) {
            $arProductIDList = $obCampaignItem->product->getIDList();
            if (empty($arProductIDList)) {
                continue;
            }

            $arResult = array_merge($arResult, $arProductIDList);
        }

        $arResult = array_unique($arResult);

        return $arResult;
    }

    /**
     * After save event handler
     */
    protected function afterSave()
    {
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        CampaignListStore::instance()->promo_block->clear($this->obElement->id);
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass()
    {
        return PromoBlock::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return PromoBlockItem::class;
    }
}
