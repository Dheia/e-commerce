<?php namespace Lovata\AccessoriesShopaholic;

use Event;
use System\Classes\PluginBase;

use Lovata\AccessoriesShopaholic\Classes\Event\ProductControllerHandler;
use Lovata\AccessoriesShopaholic\Classes\Event\ProductModelHandler;

/**
 * Class Plugin
 * @package Lovata\AccessoriesShopaholic
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class Plugin extends PluginBase
{
    /** @var array Plugin dependencies */
    public $require = ['Lovata.Shopaholic', 'Lovata.Toolbox'];

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
        Event::subscribe(ProductControllerHandler::class);
        Event::subscribe(ProductModelHandler::class);
    }
}
