<?php namespace Lovata\SubscriptionsShopaholic\Classes\Event\OrderPosition;

use Lovata\Toolbox\Classes\Event\AbstractBackendFieldHandler;

use Lovata\OrdersShopaholic\Models\OrderPosition;
use Lovata\OrdersShopaholic\Controllers\OrderPositions;

/**
 * Class ExtendOrderPositionFieldsHandler
 * @package Lovata\SubscriptionsShopaholic\Classes\Event\OrderPosition
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendOrderPositionFieldsHandler extends AbstractBackendFieldHandler
{
    /**
     * Extend subscription access field
     * @param \Backend\Widgets\Form $obWidget
     */
    protected function extendFields($obWidget)
    {
        $arFieldList = [
            'is_subscription'     => [
                'label'    => 'lovata.subscriptionsshopaholic::lang.field.is_subscription',
                'tab'      => 'lovata.toolbox::lang.tab.settings',
                'type'     => 'checkbox',
                'span'     => 'left',
                'disabled' => true,
                'trigger'     => [
                    'action'    => 'show',
                    'condition' => 'checked',
                    'field'     => 'is_subscription',
                ],
            ],
            'subscription_period' => [
                'label'       => 'lovata.subscriptionsshopaholic::lang.field.period_access',
                'tab'         => 'lovata.toolbox::lang.tab.settings',
                'type'        => 'relation',
                'emptyOption' => 'lovata.subscriptionsshopaholic::lang.field.unlimited_period',
                'nameFrom'    => 'name',
                'span'        => 'left',
                'disabled'    => true,
                'trigger'     => [
                    'action'    => 'show',
                    'condition' => 'checked',
                    'field'     => 'is_subscription',
                ],
            ],
        ];

        $obWidget->addTabFields($arFieldList);
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass() : string
    {
        return OrderPosition::class;
    }

    /**
     * Get controller class name
     * @return string
     */
    protected function getControllerClass() : string
    {
        return OrderPositions::class;
    }
}
