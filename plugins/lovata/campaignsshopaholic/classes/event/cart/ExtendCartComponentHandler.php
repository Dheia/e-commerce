<?php namespace Lovata\CampaignsShopaholic\Classes\Event\Cart;

use Lovata\CampaignsShopaholic\Classes\Helper\CampaignHelper;

use Lovata\OrdersShopaholic\Components\Cart;

/**
 * Class ExtendCartComponentHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\Cart
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendCartComponentHandler
{
    /**
     * Add listeners
     */
    public function subscribe()
    {
        Cart::extend(function ($obComponent) {
            /** @var Cart $obComponent */
            $this->getCampaignListMethod($obComponent);
        });
    }

    /**
     * Extend Cart component and add method "getCampaignListMethod"
     * @param Cart $obComponent
     */
    protected function getCampaignListMethod($obComponent)
    {
        $obComponent->addDynamicMethod('getAppliedCampaignList', function() {
            $obCampaignList = CampaignHelper::instance()->getAppliedCampaignList();

            return $obCampaignList;
        });
    }
}
