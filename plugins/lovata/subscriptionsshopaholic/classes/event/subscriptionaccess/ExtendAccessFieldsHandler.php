<?php namespace Lovata\SubscriptionsShopaholic\Classes\Event\SubscriptionAccess;

use Lovata\Toolbox\Classes\Event\AbstractBackendFieldHandler;

use Lovata\Toolbox\Classes\Helper\UserHelper;
use Lovata\SubscriptionsShopaholic\Models\SubscriptionAccess;
use Lovata\SubscriptionsShopaholic\Controllers\SubscriptionAccesses;

/**
 * Class ExtendAccessFieldsHandler
 * @package Lovata\SubscriptionsShopaholic\Classes\Event\SubscriptionAccess
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendAccessFieldsHandler extends AbstractBackendFieldHandler
{
    /**
     * Extend subscription access field
     * @param \Backend\Widgets\Form $obWidget
     */
    protected function extendFields($obWidget)
    {
        $sPluginName = UserHelper::instance()->getPluginName();
        if ($sPluginName == 'RainLab.User') {
            $arFieldList = [
                'user' => [
                    'label'  => 'lovata.ordersshopaholic::lang.field.user',
                    'type'   => 'relation',
                    'span'   => 'left',
                    'select' => "concat_ws(' ', name, surname, ' (', email, ')')",
                ],
            ];
        } else {
            $arFieldList = [
                'user' => [
                    'label'  => 'lovata.ordersshopaholic::lang.field.user',
                    'type'   => 'relation',
                    'span'   => 'left',
                    'select' => "concat_ws(' ', name, last_name, ' (', email, ')')",
                ],
            ];
        }

        $obWidget->addFields($arFieldList);
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
