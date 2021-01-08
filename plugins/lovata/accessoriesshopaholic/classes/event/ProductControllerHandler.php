<?php namespace Lovata\AccessoriesShopaholic\Classes\Event;

use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Controllers\Products;

/**
 * Class ProductControllerHandler
 * @package Lovata\AccessoriesShopaholic\Classes\Event
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ProductControllerHandler
{
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        Products::extend(function ($obController) {
            $this->extendConfig($obController);
        });

        $obEvent->listen('backend.form.extendFields', function ($obWidget) {
            $this->extendFields($obWidget);
        });
    }

    /**
     * Extend products controller
     * @param Products $obController
     */
    protected function extendConfig($obController)
    {
        $obController->relationConfig = $obController->mergeConfig(
            $obController->relationConfig,
            '$/lovata/accessoriesshopaholic/config/product_config_relation.yaml'
        );
    }

    /**
     * Extend products field
     * @param \Backend\Widgets\Form $obWidget
     */
    protected function extendFields($obWidget)
    {
        if (!$obWidget->getController() instanceof Products || $obWidget->isNested) {
            return;
        }

        if (!$obWidget->model instanceof Product) {
            return;
        }

        $arAdditionFields = [
            'accessory' => [
                'type'    => 'partial',
                'tab'     => 'lovata.accessoriesshopaholic::lang.tab.accessory',
                'path'    => '$/lovata/accessoriesshopaholic/views/accessory.htm',
                'context' => ['update'],
            ],
        ];

        $obWidget->addTabFields($arAdditionFields);
    }
}
