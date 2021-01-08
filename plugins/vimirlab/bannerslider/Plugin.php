<?php namespace VimirLab\BannerSlider;

use Event;
use Backend;
use Cms\Classes\Controller;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
	public function pluginDetails()
	{
		return [
			'name'        => 'vimirlab.bannerslider::lang.plugin.name',
            'description' => 'vimirlab.bannerslider::lang.plugin.description',
            'author'      => 'vimirlab.bannerslider::lang.plugin.author',
            'icon'        => 'icon-picture-o',
		];
	}

    public function registerPermissions()
    {
        return [
            'vimirlab.bannerslider.sliders' => [
                'label' => 'vimirlab.bannerslider::lang.permission.sliders',
                'tab' => 'vimirlab.bannerslider::lang.menu.bannerslider',
            ],
        ];
    }
		
	public function registerNavigation()
    {
        return [
            'bannerslider' => [
                'label'       => 'vimirlab.bannerslider::lang.menu.bannerslider',
                'url'         => Backend::url('vimirlab/bannerslider/sliders'),
                'icon'        => 'icon-picture-o',
                'permissions' => ['vimirlab.bannerslider.*'],
                'order'       => 500,
				'category'    => 'VimirLab plugins',
                
                'sideMenu'    => [
                    'sliders'  => [
                        'label'       => 'vimirlab.bannerslider::lang.menu.bannerslider',
                        'url'         => Backend::url('vimirlab/bannerslider/sliders'),
                        'icon'        => 'icon-picture-o',
                        'permissions' => ['vimirlab.bannerslider.sliders'],
                    ],
                ]
            ]
        ];
    }	
	
	public function registerComponents()
	{
		return [
			'VimirLab\BannerSlider\Components\Sliders' => 'sliders'
		];
	}
}