<?php namespace Lovata\CampaignsShopaholic\Models;

use Model;
use October\Rain\Argon\Argon;
use October\Rain\Database\Traits\Validation;

use Kharanenka\Scope\ActiveField;
use Lovata\Toolbox\Traits\Helpers\TraitCached;

use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\PromoBlock;
use Lovata\OrdersShopaholic\Models\ShippingType;
use Lovata\OrdersShopaholic\Models\PromoMechanism;

/**
 * Class Campaign
 * @package Lovata\CampaignsShopaholic\Models
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @mixin \October\Rain\Database\Builder
 * @mixin \Eloquent
 *
 * @property int                                                                   $id
 * @property bool                                                                  $active
 *
 * @property string                                                                $name
 * @property \October\Rain\Argon\Argon                                             $date_begin
 * @property \October\Rain\Argon\Argon                                             $date_end
 * @property int                                                                   $promo_mechanism_id
 * @property int                                                                   $promo_block_id
 * @property string                                                                $preview_text
 * @property string                                                                $description
 * @property \October\Rain\Argon\Argon                                             $created_at
 * @property \October\Rain\Argon\Argon                                             $updated_at
 *
 * @property PromoMechanism                                                        $mechanism
 * @method static PromoMechanism|\October\Rain\Database\Relations\BelongsTo mechanism()
 * @property PromoBlock                                                            $promo_block
 * @method static PromoBlock|\October\Rain\Database\Relations\BelongsTo promo_block()
 * @property Product[]|\October\Rain\Database\Collection                           $product
 * @method static Product|\October\Rain\Database\Relations\BelongsToMany product()
 * @property Offer[]|\October\Rain\Database\Collection                             $offer
 * @method static Offer|\October\Rain\Database\Relations\BelongsToMany offer()
 * @property Brand[]|\October\Rain\Database\Collection                             $brand
 * @method static Brand|\October\Rain\Database\Relations\BelongsToMany brand()
 * @property Category[]|\October\Rain\Database\Collection                          $category
 * @method static Category|\October\Rain\Database\Relations\BelongsToMany category()
 * @property ShippingType[]|\October\Rain\Database\Collection                      $shipping_type
 * @method static ShippingType|\October\Rain\Database\Relations\BelongsToMany shipping_type()
 * @property \Lovata\TagsShopaholic\Models\Tag[]|\October\Rain\Database\Collection $tag
 * @method static \Lovata\TagsShopaholic\Models\Tag|\October\Rain\Database\Relations\BelongsToMany tag()
 *
 * @method static $this currentActive()
 * @method static $this getByPromoBlock($iPromoBlock)
 * @method static $this getByPromoMechanism($iPromoMechanism)
 */
class Campaign extends Model
{
    use Validation;
    use TraitCached;
    use ActiveField;

    public $table = 'lovata_campaigns_shopaholic_campaigns';

    public $rules = [
        'date_begin'         => 'required',
        'name'               => 'required',
        'promo_mechanism_id' => 'required',
    ];

    public $attributeNames = [
        'name'               => 'lovata.toolbox::lang.field.name',
        'date_begin'         => 'lovata.toolbox::lang.field.date_begin',
        'promo_mechanism_id' => 'lovata.ordersshopaholic::lang.field.promo_mechanism',
    ];

    public $fillable = [
        'active',
        'name',
        'date_begin',
        'date_end',
        'promo_mechanism_id',
        'promo_block_id',
        'preview_text',
        'description',
    ];

    public $cached = [
        'id',
        'name',
        'date_begin',
        'date_end',
        'promo_block_id',
        'preview_text',
        'description',
    ];

    public $dates = ['created_at', 'updated_at', 'date_begin', 'date_end'];
    public $attachOne = [];
    public $attachMany = [];

    public $belongsTo = [
        'mechanism'   => [
            PromoMechanism::class,
            'key' => 'promo_mechanism_id',
            'conditions' => 'increase = false',
        ],
        'promo_block' => [
            PromoBlock::class,
            'key' => 'promo_block_id',
        ],
    ];

    public $belongsToMany = [
        'product'       => [
            Product::class,
            'table' => 'lovata_campaigns_shopaholic_campaign_product',
        ],
        'offer'         => [
            Offer::class,
            'table' => 'lovata_campaigns_shopaholic_campaign_offer',
        ],
        'brand'         => [
            Brand::class,
            'table' => 'lovata_campaigns_shopaholic_campaign_brand',
        ],
        'category'      => [
            Category::class,
            'table' => 'lovata_campaigns_shopaholic_campaign_category',
        ],
        'shipping_type' => [
            ShippingType::class,
            'table' => 'lovata_campaigns_shopaholic_campaign_shipping_type',
        ],
    ];

    /**
     * Before save event handler
     */
    public function beforeValidate()
    {
        $obDateBegin = $this->date_begin;
        if (empty($obDateBegin)) {
            $this->date_begin = Argon::now();
        }
    }

    /**
     * Get promo mechanism object from mechanism relation
     * @return \Lovata\OrdersShopaholic\Classes\PromoMechanism\InterfacePromoMechanism|null
     */
    public function getPromoMechanismObject()
    {
        $obMechanismModel = $this->mechanism;
        if (empty($obMechanismModel)) {
            return null;
        }

        $obPromoMechanism = $obMechanismModel->getTypeObject();
        $obPromoMechanism->setRelatedModel($this);

        return $obPromoMechanism;
    }

    /**
     * Get active elements
     * @param Campaign $obQuery
     * @return Campaign
     */
    public function scopeCurrentActive($obQuery)
    {
        $sDateNow = Argon::now()->toDateTimeString();

        return $obQuery->where('date_begin', '<=', $sDateNow)
            ->where(function ($obQuery) use ($sDateNow) {
                /** @var Campaign $obQuery */
                $obQuery->whereNull('date_end')->orWhere('date_end', '>', $sDateNow);
            });
    }

    /**
     * Get elements by promo block ID
     * @param Campaign $obQuery
     * @param string   $sData
     * @return Campaign
     */
    public function scopeGetByPromoBlock($obQuery, $sData)
    {
        if (!empty($sData)) {
            $obQuery->where('promo_block_id', $sData);
        }

        return $obQuery;
    }

    /**
     * Get elements by promo mechanism ID
     * @param Campaign $obQuery
     * @param string   $sData
     * @return Campaign
     */
    public function scopeGetByPromoMechanism($obQuery, $sData)
    {
        if (!empty($sData)) {
            $obQuery->where('promo_mechanism_id', $sData);
        }

        return $obQuery;
    }
}
