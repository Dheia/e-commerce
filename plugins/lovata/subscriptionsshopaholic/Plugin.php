<?php namespace Lovata\SubscriptionsShopaholic;

use Event;
use Backend;
use System\Classes\PluginBase;

//Events
use Lovata\SubscriptionsShopaholic\Classes\Event\ExtendBackendMenuHandler;
use Lovata\SubscriptionsShopaholic\Classes\Event\ExtendSettingsFieldHandler;
//SubscriptionAccess events
use Lovata\SubscriptionsShopaholic\Classes\Event\SubscriptionAccess\SubscriptionAccessModelHandler;
use Lovata\SubscriptionsShopaholic\Classes\Event\SubscriptionAccess\ExtendAccessColumnsHandler;
use Lovata\SubscriptionsShopaholic\Classes\Event\SubscriptionAccess\ExtendAccessFieldsHandler;
//SubscriptionPeriod events
use Lovata\SubscriptionsShopaholic\Classes\Event\SubscriptionPeriod\SubscriptionPeriodModelHandler;
//Offer events
use Lovata\SubscriptionsShopaholic\Classes\Event\Offer\ExtendOfferCollectionHandler;
use Lovata\SubscriptionsShopaholic\Classes\Event\Offer\ExtendOfferFieldsHandler;
use Lovata\SubscriptionsShopaholic\Classes\Event\Offer\OfferModelHandler;
//Order events
use Lovata\SubscriptionsShopaholic\Classes\Event\Order\OrderModelHandler;
//Order position events
use Lovata\SubscriptionsShopaholic\Classes\Event\OrderPosition\ExtendOrderPositionFieldsHandler;
use Lovata\SubscriptionsShopaholic\Classes\Event\OrderPosition\OrderPositionModelHandler;
//Product events
use Lovata\SubscriptionsShopaholic\Classes\Event\Product\ExtendProductFieldsHandler;
use Lovata\SubscriptionsShopaholic\Classes\Event\Product\ProductModelHandler;
//User events
use Lovata\SubscriptionsShopaholic\Classes\Event\User\UserModelHandler;

/**
 * Class Plugin
 * @package Lovata\SubscriptionsShopaholic
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class Plugin extends PluginBase
{
    /** @var array Plugin dependencies */
    public $require = ['Lovata.OrdersShopaholic', 'Lovata.Shopaholic', 'Lovata.Toolbox'];

    /**
     * Plugin boot method
     */
    public function boot()
    {
        $this->addEventListener();
    }

    /**
     * Add event listeners
     */
    protected function addEventListener()
    {
        Event::subscribe(ExtendBackendMenuHandler::class);
        Event::subscribe(ExtendSettingsFieldHandler::class);
        //SubscriptionAccess events
        Event::subscribe(SubscriptionAccessModelHandler::class);
        Event::subscribe(ExtendAccessColumnsHandler::class);
        Event::subscribe(ExtendAccessFieldsHandler::class);
        //SubscriptionPeriod events
        Event::subscribe(SubscriptionPeriodModelHandler::class);
        //Offer events
        Event::subscribe(ExtendOfferCollectionHandler::class);
        Event::subscribe(ExtendOfferFieldsHandler::class);
        Event::subscribe(OfferModelHandler::class);
        //Order events
        Event::subscribe(OrderModelHandler::class);
        //Order position events
        Event::subscribe(ExtendOrderPositionFieldsHandler::class);
        Event::subscribe(OrderPositionModelHandler::class);
        //Product events
        Event::subscribe(ExtendProductFieldsHandler::class);
        Event::subscribe(ProductModelHandler::class);
        //User events
        Event::subscribe(UserModelHandler::class);
    }

    /**
     * @return array
     */
    public function registerSettings()
    {
        return [
            'shopaholic-menu-subscription-period'      => [
                'label'       => 'lovata.subscriptionsshopaholic::lang.menu.period',
                'description' => 'lovata.subscriptionsshopaholic::lang.menu.period_description',
                'category'    => 'lovata.shopaholic::lang.tab.settings',
                'icon'        => 'oc-icon-key',
                'url'         => Backend::url('lovata/subscriptionsshopaholic/subscriptionperiods'),
                'order'       => 2200,
                'permissions' => [
                    'shopaholic-menu-subscription-period',
                ],
            ],
        ];
    }
}
