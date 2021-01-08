<?php namespace Lovata\CampaignsShopaholic\Classes\Event\Campaign;

use Lovata\Toolbox\Classes\Event\AbstractModelRelationHandler;

use Lovata\CampaignsShopaholic\Models\Campaign;
use Lovata\CampaignsShopaholic\Classes\Store\ProductListStore;
use Lovata\CampaignsShopaholic\Classes\Store\OfferListStore;
use Lovata\CampaignsShopaholic\Classes\Store\ShippingTypeListStore;

/**
 * Class CampaignRelationHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\Campaign
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class CampaignRelationHandler extends AbstractModelRelationHandler
{
    protected $iPriority = 900;

    /**
     * After attach event handler
     * @param Campaign $obModel
     * @param array    $arAttachedIDList
     * @param array    $arInsertData
     */
    protected function afterAttach($obModel, $arAttachedIDList, $arInsertData)
    {
        $this->clearCachedList($obModel);
    }

    /**
     * After detach event handler
     * @param Campaign $obModel
     * @param array    $arAttachedIDList
     */
    protected function afterDetach($obModel, $arAttachedIDList)
    {
        $this->clearCachedList($obModel);
    }

    /**
     * Clear cached list
     * @param Campaign $obModel
     */
    protected function clearCachedList($obModel)
    {
        if ($this->sRelationName == 'shipping_type') {
            ShippingTypeListStore::instance()->campaign->clear($obModel->id);
            return;
        }

        ProductListStore::instance()->campaign->clear($obModel->id);
        ProductListStore::instance()->campaign->clear($obModel->id, true);
        if ($this->sRelationName == 'offer') {
            OfferListStore::instance()->campaign->clear($obModel->id);
        }
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass() : string
    {
        return Campaign::class;
    }

    /**
     * Get relation name
     * @return array
     */
    protected function getRelationName()
    {
        return ['product', 'offer', 'brand', 'category', 'shipping_type', 'tag'];
    }
}
