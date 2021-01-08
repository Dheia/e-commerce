<?php namespace Lovata\ReviewsShopaholic\Classes\Item;

use Lovata\Toolbox\Classes\Item\ElementItem;

use Lovata\Shopaholic\Classes\Item\ProductItem;
use Lovata\ReviewsShopaholic\Models\Review;

/**
 * Class ReviewItem
 * @package Lovata\ReviewsShopaholic\Classes\Item
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property \October\Rain\Argon\Argon $created_at
 * @property int $rating
 * @property string $comment
 * @property int $product_id
 * @property ProductItem $product
 */
class ReviewItem extends ElementItem
{
    const MODEL_CLASS = Review::class;
    
    /** @var Review */
    protected $obElement = null;
    
    public $arRelationList = [
        'product' => [
            'class' => ProductItem::class,
            'field' => 'product_id',
        ],
    ];
}
