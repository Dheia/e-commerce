<?php namespace Lovata\CampaignsShopaholic\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Class Campaigns
 * @package Lovata\CampaignsShopaholic\Controllers
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class Campaigns extends Controller
{
    public $implement = [
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.RelationController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    protected $obGenerateFormWidget;

    /**
     * Campaigns constructor.
     */
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Lovata.Shopaholic', 'shopaholic-menu-promo', 'shopaholic-menu-promo-campaign');
    }
}
