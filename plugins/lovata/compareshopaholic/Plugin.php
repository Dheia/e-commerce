<?php namespace Lovata\CompareShopaholic;

use Event;
use System\Classes\PluginBase;

use Lovata\CompareShopaholic\Classes\Event\ExtendUserModel;
use Lovata\CompareShopaholic\Classes\Event\ExtendProductItem;
use Lovata\CompareShopaholic\Classes\Event\ExtendProductComponent;
use Lovata\CompareShopaholic\Classes\Event\ExtendProductCollection;

/**
 * Class Plugin
 * @package Lovata\CompareShopaholic
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
        Event::subscribe(ExtendProductCollection::class);
        Event::subscribe(ExtendProductItem::class);
        Event::subscribe(ExtendProductComponent::class);
        Event::subscribe(ExtendUserModel::class);
    }
}
