<?php namespace Lovata\SubscriptionsShopaholic\Classes\Event;

use Backend;
use Lovata\Toolbox\Classes\Helper\UserHelper;
use Lovata\Toolbox\Classes\Event\AbstractBackendMenuHandler;

/**
 * Class ExtendBackendMenuHandler
 * @package Lovata\SubscriptionsShopaholic\Classes\Event
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
        $arMenuItem = [
            'label'       => 'lovata.subscriptionsshopaholic::lang.menu.access',
            'url'         => Backend::url('lovata/subscriptionsshopaholic/subscriptionaccesses'),
            'icon'        => 'oc-icon-key',
            'permissions' => ['shopaholic-menu-subscription-access'],
        ];

        $sPluginName = UserHelper::instance()->getPluginName();
        if ($sPluginName == 'RainLab.User') {
            $obManager->addSideMenuItem('RainLab.User', 'user', 'subscription-menu-access', $arMenuItem);
        } else {
            $obManager->addSideMenuItem('Lovata.Buddies', 'main-menu-buddies', 'subscription-menu-access', $arMenuItem);
        }
    }
}
