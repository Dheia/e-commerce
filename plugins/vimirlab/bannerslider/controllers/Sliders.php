<?php namespace VimirLab\BannerSlider\Controllers;

use Flash;
use Lang;
use BackendMenu;
use Backend\Classes\Controller;

class Sliders extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relations.yaml';

    public $requiredPermissions = ['vimirlab.bannerslider.sliders'];
	
	public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('VimirLab.BannerSlider', 'bannerslider', 'sliders');
    }	
}

