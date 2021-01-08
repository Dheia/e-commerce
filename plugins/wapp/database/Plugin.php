<?php namespace Wapp\Database;

use Backend;
use System\Classes\PluginBase;

/**
 * database Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public $require = [
        'Lovata.Shopaholic',
        'Rainlab.Blog',
        'Vimirlab.Bannerslider',
        'Lovata.LabelsShopaholic',
    ];


    public function pluginDetails()
    {
        return [
            'name'        => 'database',
            'description' => 'No description provided yet...',
            'author'      => 'wapp',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {

        return [
            'Wapp\Database\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {

        return [
            'wapp.database.some_permission' => [
                'tab' => 'database',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {

        return [];
    }
}
