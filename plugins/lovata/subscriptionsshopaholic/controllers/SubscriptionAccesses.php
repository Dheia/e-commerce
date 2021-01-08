<?php namespace Lovata\SubscriptionsShopaholic\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

use Lovata\Toolbox\Classes\Helper\UserHelper;

/**
 * Class SubscriptionAccesses
 * @package Lovata\SubscriptionsShopaholic\Controllers
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class SubscriptionAccesses extends Controller
{
    public $implement = [
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.RelationController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    /**
     * Brands constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $sPluginName = UserHelper::instance()->getPluginName();
        if ($sPluginName == 'RainLab.User') {
            BackendMenu::setContext('RainLab.User', 'user', 'subscription-menu-access');
        } else {
            BackendMenu::setContext('Lovata.Buddies', 'main-menu-buddies', 'subscription-menu-access');
        }
    }
}
