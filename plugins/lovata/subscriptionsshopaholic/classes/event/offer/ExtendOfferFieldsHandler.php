<?php namespace Lovata\SubscriptionsShopaholic\Classes\Event\Offer;

use Lovata\Toolbox\Classes\Event\AbstractBackendFieldHandler;

use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Controllers\Offers;

/**
 * Class ExtendOfferFieldsHandler
 * @package Lovata\SubscriptionsShopaholic\Classes\Event\Offer
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendOfferFieldsHandler extends AbstractBackendFieldHandler
{
    protected $iPriority = 200;

    /**
     * Extend products field
     * @param \Backend\Widgets\Form $obWidget
     */
    protected function extendFields($obWidget)
    {
        /** @var Offer $obOffer */
        $obOffer = $obWidget->model;
        $obProduct = $obOffer->product;
        if (empty($obProduct) || !$obProduct->is_subscription) {
            return;
        }

        $arAdditionFields = [
            'subscription_period' => [
                'label'       => 'lovata.subscriptionsshopaholic::lang.field.period',
                'tab'         => 'lovata.toolbox::lang.tab.settings',
                'emptyOption' => 'lovata.subscriptionsshopaholic::lang.field.unlimited_period',
                'type'        => 'relation',
                'span'        => 'left',
            ],
        ];

        $obWidget->addTabFields($arAdditionFields);
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass() : string
    {
        return Offer::class;
    }

    /**
     * Get controller class name
     * @return string
     */
    protected function getControllerClass() : string
    {
        return Offers::class;
    }
}
