<?php namespace Lovata\SubscriptionsShopaholic\Models;

use Model;
use October\Rain\Argon\Argon;
use October\Rain\Database\Traits\Validation;

use Kharanenka\Scope\UserBelongsTo;
use Lovata\Toolbox\Classes\Helper\UserHelper;
use Lovata\Toolbox\Traits\Helpers\TraitCached;

use Lovata\Shopaholic\Models\Product;
use Lovata\OrdersShopaholic\Models\OrderPosition;

/**
 * Class SubscriptionAccess
 * @package Lovata\SubscriptionsShopaholic\Models
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @mixin \October\Rain\Database\Builder
 * @mixin \Eloquent
 *
 * @property int                                               $id
 * @property int                                               $product_id
 * @property int                                               $user_id
 * @property int                                               $element_id
 * @property string                                            $element_type
 * @property \October\Rain\Argon\Argon                         $expire_at
 * @property \October\Rain\Argon\Argon                         $created_at
 * @property \October\Rain\Argon\Argon                         $updated_at
 *
 * @property \October\Rain\Database\Collection|OrderPosition[] $order_position
 * @method static \October\Rain\Database\Relations\HasMany|OrderPosition order_position()
 *
 * @property Product                                           $product
 * @method static \October\Rain\Database\Relations\BelongsTo|Product product()
 *
 * @property \Lovata\Buddies\Models\User                       $user
 * @method static \Lovata\Buddies\Models\User|\October\Rain\Database\Relations\BelongsTo user()
 *
 * @method static $this getByProduct(int $iProductID)
 * @method static $this getByElementID(int $iElementID)
 * @method static $this getByElementType(int $iElementType)
 */
class SubscriptionAccess extends Model
{
    use Validation;
    use TraitCached;
    use UserBelongsTo;

    public $table = 'lovata_subscription_shopaholic_access';

    public $rules = [
        'product_id' => 'required',
        'user_id'    => 'required',
    ];

    public $attributeNames = [
        'product' => 'lovata.toolbox::lang.field.product',
        'period'  => 'lovata.ordersshopaholic::lang.field.user',
    ];

    public $attachOne = [];
    public $attachMany = [];
    public $hasMany = [
        'order_position' => [
            OrderPosition::class
        ],
    ];
    public $belongsTo = [
        'product' => [
            Product::class,
        ],
    ];
    public $belongsToMany = [];
    public $morphTo = [
        'element' => [],
    ];
    public $morphMany = [];

    public $dates = ['created_at', 'updated_at', 'expire_at'];

    public $appends = [];
    public $purgeable = [];

    public $fillable = [
        'product_id',
        'user_id',
        'expire_at',
    ];

    public $cached = [
        'id',
        'product_id',
        'user_id',
        'expire_at',
        'element_id',
        'element_type',
    ];

    public $visible = [];
    public $hidden = [];

    /**
     * Order constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $sUserModelClass = UserHelper::instance()->getUserModel();
        if (!empty($sUserModelClass)) {
            $this->belongsTo['user'] = [$sUserModelClass];
        }

        parent::__construct($attributes);
    }

    /**
     * Get element by product ID
     * @param SubscriptionAccess $obQuery
     * @param string               $sData
     *
     * @return SubscriptionAccess
     */
    public function scopeGetByProduct($obQuery, $sData)
    {
        if (!empty($sData)) {
            $obQuery->where('product_id', $sData);
        }

        return $obQuery;
    }

    /**
     * Get element by element ID
     * @param SubscriptionAccess $obQuery
     * @param string               $sData
     *
     * @return SubscriptionAccess
     */
    public function scopeGetByElementID($obQuery, $sData)
    {
        if (!empty($sData)) {
            $obQuery->where('element_id', $sData);
        }

        return $obQuery;
    }

    /**
     * Get element by element type
     * @param SubscriptionAccess $obQuery
     * @param string               $sData
     *
     * @return SubscriptionAccess
     */
    public function scopeGetByElementType($obQuery, $sData)
    {
        if (!empty($sData)) {
            $obQuery->where('element_type', $sData);
        }

        return $obQuery;
    }

    /**
     * Return true, if user has access to subscription
     * @return bool
     */
    public function isActive()
    {
        $obExpireDate = $this->expire_at;
        if (empty($obExpireDate)) {
            return true;
        }

        $obDateNow = Argon::now();

        $bResult = $obDateNow->toDateTimeString() <= $obExpireDate->toDateTimeString();

        return $bResult;
    }
}
