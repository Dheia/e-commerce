<?php namespace Lovata\SubscriptionsShopaholic\Classes\Event\SubscriptionAccess;

use Lovata\Toolbox\Classes\Event\AbstractBackendColumnHandler;

use Lovata\Toolbox\Classes\Helper\UserHelper;
use Lovata\SubscriptionsShopaholic\Models\SubscriptionAccess;
use Lovata\SubscriptionsShopaholic\Controllers\SubscriptionAccesses;

/**
 * Class ExtendAccessColumnsHandler
 * @package Lovata\SubscriptionsShopaholic\Classes\Event\SubscriptionAccess
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendAccessColumnsHandler extends AbstractBackendColumnHandler
{
    /**
     * Extend backend columns
     * @param \Backend\Widgets\Lists $obWidget
     */
    protected function extendColumns($obWidget)
    {
        $sPluginName = UserHelper::instance()->getPluginName();
        if ($sPluginName == 'RainLab.User') {
            $obWidget->removeColumn('buddies_user');
        } else {
            $obWidget->removeColumn('rainlab_user');
        }
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass() : string
    {
        return SubscriptionAccess::class;
    }

    /**
     * Get controller class name
     * @return string
     */
    protected function getControllerClass() : string
    {
        return SubscriptionAccesses::class;
    }
}
