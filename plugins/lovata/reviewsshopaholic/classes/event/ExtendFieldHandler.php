<?php namespace Lovata\ReviewsShopaholic\Classes\Event;

use System\Controllers\Settings as SettingsController;
use Lovata\Shopaholic\Models\Settings as SettingsModel;

/**
 * Class ExtendFieldHandler
 * @package Lovata\ReviewsShopaholic\Classes\Event
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
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
     * Extend Product fields
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
            'rating_from' => [
                'label'   => 'lovata.reviewsshopaholic::lang.field.rating_from',
                'tab'     => 'lovata.reviewsshopaholic::lang.tab.review_settings',
                'span'    => 'left',
                'default' => 1,
                'type'    => 'number',
            ],
            'rating_to' => [
                'label'   => 'lovata.reviewsshopaholic::lang.field.rating_to',
                'tab'     => 'lovata.reviewsshopaholic::lang.tab.review_settings',
                'span'    => 'right',
                'default' => 5,
                'type'    => 'number',
            ],
            'review_activation' => [
                'label'   => 'lovata.reviewsshopaholic::lang.field.review_activation',
                'tab'     => 'lovata.reviewsshopaholic::lang.tab.review_settings',
                'span'    => 'left',
                'type'    => 'checkbox',
            ],
        ];

        $obWidget->addTabFields($arFieldList);
    }
}
