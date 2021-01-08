<?php namespace Lovata\SubscriptionsShopaholic\Controllers;

use Event;
use BackendMenu;
use System\Classes\SettingsManager;
use Backend\Classes\Controller;

/**
 * Class SubscriptionPeriods
 * @package Lovata\SubscriptionsShopaholic\Controllers
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class SubscriptionPeriods extends Controller
{
    public $implement = [
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ReorderController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    /**
     * Brands constructor.
     */
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Lovata.SubscriptionsShopaholic', 'shopaholic-menu-subscription-period');
    }

    /**
     * Ajax handler onReorder event
     *
     * @return mixed
     */
    public function onReorder()
    {
        $obResult = parent::onReorder();
        Event::fire('shopaholic.subscription_period.update.sorting');

        return $obResult;
    }
}
