<?php namespace Wapp\BaseCode;

use Backend;
use Event;
use System\Classes\PluginBase;
//UserAddress event
use Wapp\BaseCode\Classes\Event\UserAddress\ExtendUserAddressModel;

//Brand events
use Wapp\BaseCode\Classes\Event\Brand\BrandCollectionHandler;
//Events
use Wapp\BaseCode\Classes\Event\Category\CategoryModelHandler;
use Wapp\BaseCode\Classes\Event\Category\ExtendCategoryFieldsHandler;
use Wapp\Basecode\Components\ExtendUserAddressComponent;

/**
 * Basecode Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */

    public function pluginDetails()
    {
        return [
            'name'        => 'SiteSettings',
            'description' => 'No description provided yet...',
            'author'      => 'Wapp',
            'icon'        => 'icon-leaf'
        ];
    }

    public $require = [
        'Lovata.Shopaholic',
        'Lovata.OrdersShopaholic',
    ];

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
        $this->addEventListener();
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {

        return [
            'Wapp\BaseCode\Components\SiteSetting' => 'Settings',
            'Wapp\BaseCode\Components\Catalog' => 'Catalog',
            'Wapp\BaseCode\Components\Compare' => 'Compare',
            'Wapp\BaseCode\Components\Import' => 'Import',
        ];
    }

    public function registerSettings()
    {
        return [
            'config' => [
                'label'       => 'Settings',
                'icon'        => 'icon-folder',
                'description' => 'Setting for site(header,footer and oth.)',
                'class'       => 'Wapp\Basecode\Models\Settings',
                'permissions' => ['wapp.basecode.*'],
                'order'       => 600
            ]
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

        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'basecode' => [
                'label'       => 'Basecode',
                'url'         => Backend::url('wapp/basecode/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['wapp.basecode.*'],
                'order'       => 500,
            ],
        ];
    }

    private function addEventListener()
    {
        //UserAddress events
        Event::subscribe(ExtendUserAddressModel::class);
        Event::subscribe(ExtendUserAddressComponent::class);
//        Event::subscribe(ExtendUserAddressCollection::class);
        //Brand events
        Event::subscribe(BrandCollectionHandler::class);
        //Category events
        Event::subscribe(CategoryModelHandler::class);
        Event::subscribe(ExtendCategoryFieldsHandler::class);
    }
}
