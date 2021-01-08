<?php namespace Lovata\ReviewsShopaholic;

use Event;
use System\Classes\PluginBase;

use Lovata\ReviewsShopaholic\Classes\Event\BackendMenuHandler;
use Lovata\ReviewsShopaholic\Classes\Event\ExtendFieldHandler;
use Lovata\ReviewsShopaholic\Classes\Event\ProductControllerHandler;
use Lovata\ReviewsShopaholic\Classes\Event\ProductModelHandler;
use Lovata\ReviewsShopaholic\Classes\Event\ReviewModelHandler;

/**
 * Class Plugin
 * @package Lovata\ReviewsShopaholic
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class Plugin extends PluginBase
{
    const DEFAULT_RATING_FROM = 1;
    const DEFAULT_RATING_TO = 5;
    
    /** @var array Plugin dependencies */
    public $require = ['Lovata.Shopaholic', 'Lovata.Toolbox'];
    
    /**
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Lovata\ReviewsShopaholic\Components\MakeReview' => 'MakeReview',
        ];
    }

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
        Event::subscribe(BackendMenuHandler::class);
        Event::subscribe(ExtendFieldHandler::class);
        Event::subscribe(ProductControllerHandler::class);
        Event::subscribe(ProductModelHandler::class);
        Event::subscribe(ReviewModelHandler::class);
    }
}
