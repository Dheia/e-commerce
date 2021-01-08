<?php namespace Lovata\CampaignsShopaholic\Classes\Helper;

use October\Rain\Support\Traits\Singleton;

use Lovata\CampaignsShopaholic\Models\Campaign;
use Lovata\CampaignsShopaholic\Classes\Store\OfferListStore;
use Lovata\CampaignsShopaholic\Classes\Store\ProductListStore;
use Lovata\CampaignsShopaholic\Classes\Store\ShippingTypeListStore;
use Lovata\CampaignsShopaholic\Classes\Collection\CampaignCollection;

use Lovata\OrdersShopaholic\Models\OrderPromoMechanism;

/**
 * Class CampaignHelper
 * @package Lovata\CampaignsShopaholic\Classes\Helper
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class CampaignHelper
{
    use Singleton;

    /** @var Campaign */
    protected $obCampaign;

    /** @var \Lovata\CampaignsShopaholic\Models\Campaign[]|\October\Rain\Database\Collection */
    protected $obActiveCampaignList;

    /**
     * Init active campaign list
     */
    protected function init()
    {
        $this->obActiveCampaignList = Campaign::with('mechanism')->active()->currentActive()->get();
    }

    /**
     * Get campaign list, attached to cart object
     * @return \Lovata\CampaignsShopaholic\Classes\Item\CampaignItem[]|\Lovata\CampaignsShopaholic\Classes\Collection\CampaignCollection
     * @throws \Exception
     */
    public function getAppliedCampaignList()
    {
        if (empty($this->obActiveCampaignList)) {
            return CampaignCollection::make()->clear();
        }

        $obCampaignList = CampaignCollection::make()->intersect($this->obActiveCampaignList->lists('id'));

        return $obCampaignList;
    }

    /**
     * Attach campaigns to Order
     * @param \Lovata\OrdersShopaholic\Models\Order $obOrder
     * @throws \Exception
     */
    public function attachCampaignListToOrder($obOrder)
    {
        if (empty($obOrder) || empty($this->obActiveCampaignList)) {
            return;
        }

        //Process campaign list and attach campaign to Order model
        foreach ($this->obActiveCampaignList as $obCampaign) {
            $this->attachCampaignToOrder($obOrder, $obCampaign);

        }
    }

    /**
     * Attach campaign object to order object
     * @@param \Lovata\OrdersShopaholic\Models\Order $obOrder
     * @param Campaign $obCampaign
     */
    protected function attachCampaignToOrder($obOrder, $obCampaign)
    {
        if (empty($obOrder) || empty($obCampaign)) {
            return;
        }

        //Get promo mechanism object
        $obPromoMechanism = $obCampaign->mechanism;
        if (empty($obPromoMechanism)) {
            return;
        }

        $arElementData = [
            'name'               => $obCampaign->name,
            'product_list'       => ProductListStore::instance()->campaign->get($obCampaign->id, true),
            'offer_list'         => OfferListStore::instance()->campaign->get($obCampaign->id),
            'shipping_type_list' => ShippingTypeListStore::instance()->campaign->get($obCampaign->id),
        ];

        try {
            $arPromoMechanismData = [
                'order_id'       => $obOrder->id,
                'mechanism_id'   => $obPromoMechanism->id,
                'name'           => $obPromoMechanism->name,
                'type'           => $obPromoMechanism->type,
                'increase'       => $obPromoMechanism->increase,
                'priority'       => $obPromoMechanism->priority,
                'discount_value' => $obPromoMechanism->discount_value,
                'discount_type'  => $obPromoMechanism->discount_type,
                'final_discount' => $obPromoMechanism->final_discount,
                'property'       => $obPromoMechanism->property,
                'element_id'     => $obCampaign->id,
                'element_type'   => Campaign::class,
                'element_data'   => $arElementData,
            ];

            $obOrder->order_promo_mechanism()->add(OrderPromoMechanism::create($arPromoMechanismData));
        } catch (\Exception $obException) {
            return;
        }
    }
}
