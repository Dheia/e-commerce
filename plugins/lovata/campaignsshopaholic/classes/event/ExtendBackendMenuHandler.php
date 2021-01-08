<?php namespace Lovata\CampaignsShopaholic\Classes\Event;

use Backend;
use Lovata\Toolbox\Classes\Event\AbstractBackendMenuHandler;

/**
 * Class ExtendBackendMenuHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendBackendMenuHandler extends AbstractBackendMenuHandler
{
    /**
     * Add menu items
     * @param \Backend\Classes\NavigationManager $obManager
     */
    protected function addMenuItems($obManager)
    {
        $arMenuItemData = [
            'label' => 'lovata.campaignsshopaholic::lang.menu.campaign',
            'url'           => Backend::url('lovata/campaignsshopaholic/campaigns'),
            'icon'          => 'oc-icon-cart-plus',
            'permissions'   => ['shopaholic-menu-promo-campaign'],
            'order'         => 600,
        ];

        $obManager->addSideMenuItem('Lovata.Shopaholic', 'shopaholic-menu-promo', 'shopaholic-menu-promo-campaign', $arMenuItemData);
    }
}
