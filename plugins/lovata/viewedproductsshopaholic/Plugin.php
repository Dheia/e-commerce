<?php namespace Lovata\ViewedProductsShopaholic;

use Event;
use System\Classes\PluginBase;

use Lovata\ViewedProductsShopaholic\Classes\Event\ExtendUserModel;
use Lovata\ViewedProductsShopaholic\Classes\Event\ExtendFieldHandler;
use Lovata\ViewedProductsShopaholic\Classes\Event\ProductEventHandler;
use Lovata\ViewedProductsShopaholic\Classes\Event\ExtendProductComponent;
use Lovata\ViewedProductsShopaholic\Classes\Event\ExtendProductCollection;

/**
 * Class Plugin
 * @package Lovata\ViewedProductsShopaholic
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
        Event::subscribe(ExtendFieldHandler::class);
        Event::subscribe(ExtendProductCollection::class);
        Event::subscribe(ExtendUserModel::class);
        Event::subscribe(ProductEventHandler::class);
        Event::subscribe(ExtendProductComponent::class);
    }
}
