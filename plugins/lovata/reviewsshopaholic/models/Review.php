<?php namespace Lovata\ReviewsShopaholic\Models;

use Model;
use October\Rain\Database\Traits\Validation;

use Kharanenka\Scope\ActiveField;
use Lovata\Toolbox\Traits\Helpers\TraitCached;

use Lovata\Shopaholic\Models\Settings;
use Lovata\Shopaholic\Models\Product;
use Lovata\ReviewsShopaholic\Plugin;

/**
 * Class Review
 * @package Lovata\ReviewsShopaholic\Models
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @mixin \October\Rain\Database\Builder
 * @mixin \Eloquent
 *
 * @property int                       $id
 * @property bool                      $active
 * @property string                    $name
 * @property string                    $email
 * @property string                    $phone
 * @property string                    $comment
 * @property int                       $rating
 * @property \October\Rain\Argon\Argon $created_at
 * @property \October\Rain\Argon\Argon $updated_at
 *
 * @property int                       $product_id
 * @property Product                   $product
 * @method static Product|\October\Rain\Database\Relations\BelongsTo product()
 *
 * @method static $this getByProduct(int $iProductID)
 */
class Review extends Model
{
    use Validation;
    use ActiveField;
    use TraitCached;

    public $table = 'lovata_reviews_shopaholic_reviews';

    public $rules = [
        'product_id' => 'required',
    ];

    public $fillable = [
        'active',
        'name',
        'email',
        'phone',
        'comment',
        'rating',
        'product_id',
    ];

    public $cached = [
        'id',
        'name',
        'email',
        'created_at',
        'phone',
        'comment',
        'rating',
        'product_id',
    ];

    public $dates = ['created_at', 'updated_at'];

    public $belongsTo = [
        'product' => [
            Product::class,
            'table' => 'lovata_shopaholic_products',
        ],
    ];

    /**
     * Before creating event handler
     */
    public function beforeCreate()
    {
        $this->active = (bool) Settings::getValue('review_activation');
    }

    /**
     * Get element by product ID
     * @param Review $obQuery
     * @param string $sData
     * @return $this
     */
    public function scopeGetByProduct($obQuery, $sData)
    {

        if (!empty($sData)) {
            $obQuery->where('product_id', $sData);
        }

        return $obQuery;
    }

    /**
     * Get rating options (backend)
     * @return array
     */
    public function getRatingOptions()
    {
        //Get max/min rating value from settings
        $iMinRating = (int) Settings::getValue('rating_from', Plugin::DEFAULT_RATING_FROM);
        $iMaxRating = (int) Settings::getValue('rating_to', Plugin::DEFAULT_RATING_TO);
        if ($iMinRating >= $iMaxRating) {
            $iMinRating = Plugin::DEFAULT_RATING_FROM;
            $iMaxRating = Plugin::DEFAULT_RATING_TO;
        }

        $arResult = [];

        for ($iStep = $iMinRating; $iStep <= $iMaxRating; $iStep++) {
            $arResult[$iStep] = $iStep;
        }

        return $arResult;
    }

    /**
     * Set to null if iValue is a string
     * @param mixed $iValue
     * @return string
     */
    public function setRatingAttribute($iValue)
    {
        if (empty($iValue)) {
            $iValue = null;
        }

        $this->attributes['rating'] = $iValue;
    }
}
