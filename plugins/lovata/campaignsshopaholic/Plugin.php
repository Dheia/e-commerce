<?php namespace Lovata\CampaignsShopaholic;

use Event;
use System\Classes\PluginBase;

//Common events
use Lovata\CampaignsShopaholic\Classes\Event\ExtendBackendMenuHandler;
//Brand events
use Lovata\CampaignsShopaholic\Classes\Event\Brand\BrandModelHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Brand\BrandRelationHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Brand\ExtendBrandControllerHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Brand\ExtendBrandFieldsHandler;
//Campaign events
use Lovata\CampaignsShopaholic\Classes\Event\Campaign\CampaignModelHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Campaign\CampaignRelationHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Campaign\ExtendCampaignFieldsHandler;
//Cart events
use Lovata\CampaignsShopaholic\Classes\Event\Cart\ExtendCartComponentHandler;
//Category events
use Lovata\CampaignsShopaholic\Classes\Event\Category\CategoryModelHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Category\CategoryRelationHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Category\ExtendCategoryControllerHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Category\ExtendCategoryFieldsHandler;
//Offer events
use Lovata\CampaignsShopaholic\Classes\Event\Offer\OfferModelHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Offer\OfferRelationHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Offer\ExtendOfferControllerHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Offer\ExtendOfferFieldsHandler;
//Order events
use Lovata\CampaignsShopaholic\Classes\Event\Order\OrderModelHandler;
//Product events
use Lovata\CampaignsShopaholic\Classes\Event\Product\ProductModelHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Product\ProductRelationHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Product\ExtendProductCollectionHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Product\ExtendProductControllerHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Product\ExtendProductFieldsHandler;
//Promo block events
use Lovata\CampaignsShopaholic\Classes\Event\PromoBlock\PromoBlockModelHandler;
use Lovata\CampaignsShopaholic\Classes\Event\PromoBlock\ExtendPromoBlockControllerHandler;
use Lovata\CampaignsShopaholic\Classes\Event\PromoBlock\ExtendPromoBlockFieldsHandler;
//Promo mechanism events
use Lovata\CampaignsShopaholic\Classes\Event\PromoMechanism\PromoMechanismHandler;
//Shipping type events
use Lovata\CampaignsShopaholic\Classes\Event\ShippingType\ShippingTypeModelHandler;
use Lovata\CampaignsShopaholic\Classes\Event\ShippingType\ShippingTypeRelationHandler;
use Lovata\CampaignsShopaholic\Classes\Event\ShippingType\ExtendShippingTypeControllerHandler;
use Lovata\CampaignsShopaholic\Classes\Event\ShippingType\ExtendShippingTypeFieldsHandler;
//Tag events
use Lovata\CampaignsShopaholic\Classes\Event\Tag\TagModelHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Tag\TagRelationHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Tag\ExtendTagControllerHandler;
use Lovata\CampaignsShopaholic\Classes\Event\Tag\ExtendTagFieldsHandler;

/**
 * Class Plugin
 * @package Lovata\CampaignsShopaholic
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class Plugin extends PluginBase
{
    /** @var array Plugin dependencies */
    public $require = ['Lovata.OrdersShopaholic', 'Lovata.Shopaholic', 'Lovata.Toolbox'];

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
        //Common events
        Event::subscribe(ExtendBackendMenuHandler::class);
        //Brand events
        Event::subscribe(BrandModelHandler::class);
        Event::subscribe(BrandRelationHandler::class);
        Event::subscribe(ExtendBrandControllerHandler::class);
        Event::subscribe(ExtendBrandFieldsHandler::class);
        //Campaign events
        Event::subscribe(CampaignModelHandler::class);
        Event::subscribe(CampaignRelationHandler::class);
        Event::subscribe(ExtendCampaignFieldsHandler::class);
        //Cart events
        Event::subscribe(ExtendCartComponentHandler::class);
        //Category events
        Event::subscribe(CategoryModelHandler::class);
        Event::subscribe(CategoryRelationHandler::class);
        Event::subscribe(ExtendCategoryControllerHandler::class);
        Event::subscribe(ExtendCategoryFieldsHandler::class);
        //Offer events
        Event::subscribe(OfferModelHandler::class);
        Event::subscribe(OfferRelationHandler::class);
        Event::subscribe(ExtendOfferControllerHandler::class);
        Event::subscribe(ExtendOfferFieldsHandler::class);
        //Order events
        Event::subscribe(OrderModelHandler::class);
        //Product events
        Event::subscribe(ProductModelHandler::class);
        Event::subscribe(ProductRelationHandler::class);
        Event::subscribe(ExtendProductCollectionHandler::class);
        Event::subscribe(ExtendProductControllerHandler::class);
        Event::subscribe(ExtendProductFieldsHandler::class);
        //Promo block events
        Event::subscribe(PromoBlockModelHandler::class);
        Event::subscribe(ExtendPromoBlockControllerHandler::class);
        Event::subscribe(ExtendPromoBlockFieldsHandler::class);
        //Promo mechanism events
        Event::subscribe(PromoMechanismHandler::class);
        //Shipping type events
        Event::subscribe(ShippingTypeModelHandler::class);
        Event::subscribe(ShippingTypeRelationHandler::class);
        Event::subscribe(ExtendShippingTypeControllerHandler::class);
        Event::subscribe(ExtendShippingTypeFieldsHandler::class);
        //Tag events
        Event::subscribe(TagModelHandler::class);
        Event::subscribe(TagRelationHandler::class);
        Event::subscribe(ExtendTagControllerHandler::class);
        Event::subscribe(ExtendTagFieldsHandler::class);
    }
}
