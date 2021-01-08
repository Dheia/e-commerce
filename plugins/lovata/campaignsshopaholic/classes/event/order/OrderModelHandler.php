<?php namespace Lovata\CampaignsShopaholic\Classes\Event\Order;

use Lang;

use Lovata\Shopaholic\Classes\Collection\OfferCollection;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;

use Lovata\OrdersShopaholic\Models\Order;
use Lovata\OrdersShopaholic\Models\OrderPromoMechanism;
use Lovata\OrdersShopaholic\Classes\Processor\OrderProcessor;
use Lovata\OrdersShopaholic\Classes\Collection\ShippingTypeCollection;
use Lovata\OrdersShopaholic\Classes\PromoMechanism\InterfacePromoMechanism;
use Lovata\OrdersShopaholic\Classes\PromoMechanism\OrderPromoMechanismProcessor;

use Lovata\CampaignsShopaholic\Models\Campaign;
use Lovata\CampaignsShopaholic\Classes\Helper\CampaignHelper;

/**
 * Class OrderModelHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\Order
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class OrderModelHandler
{
    /** @var Order */
    protected $obElement;

    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        $obEvent->listen(OrderProcessor::EVENT_UPDATE_ORDER_AFTER_CREATE, function ($obOrder) {
            /** @var \Lovata\OrdersShopaholic\Models\Order $obOrder */
            CampaignHelper::instance()->attachCampaignListToOrder($obOrder);
        });

        $obEvent->listen(OrderPromoMechanismProcessor::EVENT_MECHANISM_ADD_CHECK_CALLBACK_METHOD, function ($obMechanism, $iElementID, $sElementType, $arElementData) {
            /** @var \Lovata\OrdersShopaholic\Classes\PromoMechanism\InterfacePromoMechanism $obMechanism */
            $obEventMechanism = $this->addCheckCallback($obMechanism, $iElementID, $sElementType, $arElementData);

            return $obEventMechanism;
        });

        $obEvent->listen(OrderPromoMechanism::EVENT_GET_DESCRIPTION, function ($obOrderMechanism) {
            /** @var OrderPromoMechanism $obOrderMechanism */
            $sResult = null;
            if ($obOrderMechanism->element_type == Campaign::class) {
                $sResult = Lang::get('lovata.campaignsshopaholic::lang.message.campaign_discount_info', ['name' => array_get($obOrderMechanism->element_data, 'name')]);
            }

            return $sResult;
        });
    }

    /**
     * Add check callback method
     * @param \Lovata\OrdersShopaholic\Classes\PromoMechanism\InterfacePromoMechanism $obMechanism $obMechanism
     * @param int                                                                      $iElementID
     * @param string                                                                   $sElementType
     * @param array                                                                    $arElementData
     * @return null|\Lovata\OrdersShopaholic\Classes\PromoMechanism\InterfacePromoMechanism
     */
    protected function addCheckCallback($obMechanism, $iElementID, $sElementType, $arElementData)
    {
        if (empty($obMechanism) || !$obMechanism instanceof InterfacePromoMechanism || $sElementType != Campaign::class) {
            return null;
        }

        $arProductIDList = (array) array_get($arElementData, 'product_list');
        $obProductList = ProductCollection::make()->intersect($arProductIDList);

        $arOfferIDList = (array) array_get($arElementData, 'offer_list');
        $obOfferList = OfferCollection::make()->intersect($arOfferIDList);

        $arShippingTypeIDList = (array) array_get($arElementData, 'shipping_type_list');
        $obShippingTypeList = ShippingTypeCollection::make()->intersect($arShippingTypeIDList);

        $obMechanism->setCheckPositionCallback(function ($obOrderPosition) use ($obProductList, $obOfferList) {
            /** @var \Lovata\OrdersShopaholic\Models\OrderPosition $obOrderPosition */
            if (empty($obOrderPosition)) {
                return false;
            }

            $obOffer = $obOrderPosition->offer;
            if (empty($obOffer)) {
                return false;
            }

            $bCheckOfferList = $obOfferList->isNotEmpty() && $obOfferList->has($obOffer->id);
            $bCheckProductList = $obProductList->isNotEmpty() && $obProductList->has($obOffer->product_id);

            $bResult = $bCheckOfferList || $bCheckProductList || ($obOfferList->isEmpty() && $obProductList->isEmpty());

            return $bResult;
        });

        $obMechanism->setCheckShippingTypeCallback(function ($obShippingType) use ($obShippingTypeList) {
            if (empty($obShippingType)) {
                return false;
            }

            $bResult = $obShippingTypeList->isEmpty() || $obShippingTypeList->has($obShippingType->id);

            return $bResult;
        });

        return $obMechanism;
    }
}
