<?php namespace Lovata\SubscriptionsShopaholic\Models;

use Model;

use October\Rain\Database\Traits\Validation;
use October\Rain\Database\Traits\Sortable;

use Lovata\Toolbox\Traits\Helpers\TraitCached;

/**
 * Class SubscriptionPeriod
 * @package Lovata\SubscriptionsShopaholic\Models
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @mixin \October\Rain\Database\Builder
 * @mixin \Eloquent
 *
 * @property                           $id
 * @property string                    $name
 * @property string                    $period
 * @property int                       $sort_order
 * @property \October\Rain\Argon\Argon $created_at
 * @property \October\Rain\Argon\Argon $updated_at
 */
class SubscriptionPeriod extends Model
{
    use Validation;
    use Sortable;
    use TraitCached;

    public $table = 'lovata_subscription_shopaholic_period';

    public $implement = [
        '@RainLab.Translate.Behaviors.TranslatableModel',
    ];

    public $translatable = ['name'];

    public $rules = [
        'name'   => 'required',
        'period' => 'required',
    ];

    public $attributeNames = [
        'name'   => 'lovata.toolbox::lang.field.name',
        'period' => 'lovata.subscriptionsshopaholic::lang.field.period',
    ];

    public $attachOne = [];
    public $attachMany = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphMany = [];

    public $dates = ['created_at', 'updated_at'];

    public $appends = [];
    public $purgeable = [];

    public $fillable = [
        'name',
        'period',
        'sort_order',
    ];

    public $cached = [
        'id',
        'name',
        'period',
    ];

    public $visible = [];
    public $hidden = [];
}
