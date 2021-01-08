<?php namespace Lovata\SubscriptionsShopaholic\Classes\Event;

use Lang;
use Lovata\Toolbox\Classes\Event\AbstractBackendFieldHandler;

use Lovata\Shopaholic\Models\Settings;
use Lovata\OrdersShopaholic\Models\Status;
use Lovata\SubscriptionsShopaholic\Classes\Helper\AccessHelper;

/**
 * Class ExtendSettingsFieldHandler
 * @package Lovata\SubscriptionsShopaholic\Classes\Event
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendSettingsFieldHandler extends AbstractBackendFieldHandler
{
    /**
     * Extend form fields
     * @param \Backend\Widgets\Form $obWidget
     */
    protected function extendFields($obWidget)
    {
        $arOrderStatus = Status::orderBy('sort_order')->lists('name', 'id');

        $arTypeList = [
            AccessHelper::TYPE_RIGHT_NOW    => Lang::get('lovata.subscriptionsshopaholic::lang.type.'.AccessHelper::TYPE_RIGHT_NOW),
            AccessHelper::TYPE_BEGIN_OF_DAY => Lang::get('lovata.subscriptionsshopaholic::lang.type.'.AccessHelper::TYPE_BEGIN_OF_DAY),
            AccessHelper::TYPE_END_OF_DAY   => Lang::get('lovata.subscriptionsshopaholic::lang.type.'.AccessHelper::TYPE_END_OF_DAY),
        ];

        $arAdditionFieldList = [
            'subscription_order_status' => [
                'tab'         => 'lovata.subscriptionsshopaholic::lang.tab.subscription',
                'label'       => 'lovata.subscriptionsshopaholic::lang.field.order_status',
                'comment'     => 'lovata.subscriptionsshopaholic::lang.field.order_status_description',
                'span'        => 'left',
                'type'        => 'dropdown',
                'emptyOption' => 'lovata.toolbox::lang.field.empty',
                'options'     => $arOrderStatus,
            ],
            'subscription_expire_type'  => [
                'tab'     => 'lovata.subscriptionsshopaholic::lang.tab.subscription',
                'label'   => 'lovata.subscriptionsshopaholic::lang.field.expire_type',
                'span'    => 'left',
                'type'    => 'dropdown',
                'options' => $arTypeList,
            ],
        ];

        $obWidget->addTabFields($arAdditionFieldList);
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass() : string
    {
        return Settings::class;
    }

    /**
     * Get controller class name
     * @return string
     */
    protected function getControllerClass() : string
    {
        return \System\Controllers\Settings::class;
    }
}
