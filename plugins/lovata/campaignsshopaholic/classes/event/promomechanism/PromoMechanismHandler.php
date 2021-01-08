<?php namespace Lovata\CampaignsShopaholic\Classes\Event\PromoMechanism;

use Lang;
use Lovata\Shopaholic\Classes\Collection\OfferCollection;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;

use Lovata\CampaignsShopaholic\Models\Campaign;
use Lovata\CampaignsShopaholic\Classes\Store\OfferListStore;
use Lovata\CampaignsShopaholic\Classes\Store\ProductListStore;
use Lovata\CampaignsShopaholic\Classes\Store\ShippingTypeListStore;

use Lovata\OrdersShopaholic\Classes\Collection\ShippingTypeCollection;
use Lovata\OrdersShopaholic\Classes\PromoMechanism\CartPromoMechanismProcessor;

/**
 * Class PromoMechanismHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\PromoMechanism
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class PromoMechanismHandler
{
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        $obEvent->listen(CartPromoMechanismProcessor::EVENT_GET_MECHANISM_LIST, function ($obPromoProcessor) {
            $this->addCampaignPromoMechanism($obPromoProcessor);
        });
    }

    /**
     * Finds active campaigns and apply promo mechanism to cart
     * @param CartPromoMechanismProcessor $obPromoProcessor
     * @throws \Exception
     */
    protected function addCampaignPromoMechanism($obPromoProcessor)
    {
        if (empty($obPromoProcessor)) {
            return;
        }

        //Get campaign list
        $obCampaignList = Campaign::with('mechanism')->active()->currentActive()->get();
        if ($obCampaignList->isEmpty()) {
            return;
        }

        foreach ($obCampaignList as $obCampaign) {
            $this->applyCampaignMechanism($obCampaign, $obPromoProcessor);
        }
    }

    /**
     * Apply campaign promo mechanism to cart
     * @param \Lovata\CampaignsShopaholic\Models\Campaign $obCampaign
     * @param CartPromoMechanismProcessor             $obPromoProcessor
     */
    protected function applyCampaignMechanism($obCampaign, $obPromoProcessor)
    {
        $obMechanism = $obCampaign->getPromoMechanismObject();
        if (empty($obMechanism)) {
            return;
        }

        $arProductIDList = ProductListStore::instance()->campaign->get($obCampaign->id, true);
        $obProductList = ProductCollection::make()->intersect($arProductIDList);

        $arOfferIDList = OfferListStore::instance()->campaign->get($obCampaign->id);
        $obOfferList = OfferCollection::make()->intersect($arOfferIDList);

        $arShippingTypeIDList = ShippingTypeListStore::instance()->campaign->get($obCampaign->id);
        $obShippingTypeList = ShippingTypeCollection::make()->intersect($arShippingTypeIDList);

        $obMechanism->setCheckPositionCallback(function ($obPosition) use ($obProductList, $obOfferList) {
            /** @var \Lovata\OrdersShopaholic\Classes\Item\CartPositionItem $obPosition */
            if (empty($obPosition)) {
                return false;
            }

            $obOfferItem = $obPosition->offer;
            if (empty($obOfferItem) || $obOfferItem->isEmpty()) {
                return false;
            }

            $bCheckOfferList = $obOfferList->isNotEmpty() && $obOfferList->has($obOfferItem->id);
            $bCheckProductList = $obProductList->isNotEmpty() && $obProductList->has($obOfferItem->product_id);

            $bResult = $bCheckOfferList || $bCheckProductList || ($obOfferList->isEmpty() && $obProductList->isEmpty());

            return $bResult;
        });

        $obMechanism->setCheckShippingTypeCallback(function ($obShippingType) use ($obShippingTypeList) {
            if (empty($obShippingType)) {
                return false;
            }

            $bResult = $obShippingTypeList->isEmpty() ||$obShippingTypeList->has($obShippingType->id);

            return $bResult;
        });

        $sResult = Lang::get('lovata.campaignsshopaholic::lang.message.campaign_discount_info', ['name' => $obCampaign->name]);
        $obMechanism->setRelatedDescription($sResult);

        $obPromoProcessor->addMechanism($obMechanism);
    }
}
