<?php namespace Lovata\ViewedProductsShopaholic\Classes\Event;

use System\Controllers\Settings as SettingsController;

use Lovata\Shopaholic\Models\Settings as SettingsModel;

/**
 * Class ExtendFieldHandler
 * @package Lovata\ViewedProductsShopaholic\Classes\Event
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendFieldHandler
{
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        $obEvent->listen('backend.form.extendFields', function ($obWidget) {
            $this->extendSettingsFields($obWidget);
        });
    }

    /**
     * Extend settings fields
     * @param \Backend\Widgets\Form $obWidget
     */
    protected function extendSettingsFields($obWidget)
    {
        if (!$obWidget->getController() instanceof SettingsController || $obWidget->isNested) {
            return;
        }

        if (!$obWidget->model instanceof SettingsModel) {
            return;
        }

        $arFieldList = [
            'viewed_product_limit' => [
                'label'       => 'lovata.viewedproductsshopaholic::lang.field.viewed_product_limit',
                'tab'         => 'lovata.toolbox::lang.tab.settings',
                'span'        => 'left',
                'placeholder' => 10,
                'type'        => 'number',
            ],
        ];

        $obWidget->addTabFields($arFieldList);
    }
}
