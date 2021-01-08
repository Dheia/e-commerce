<?php namespace Lovata\ReviewsShopaholic\Tests\Unit\Models;

use Lovata\Toolbox\Tests\CommonTest;

use Lovata\Shopaholic\Models\Product;
use Lovata\ReviewsShopaholic\Models\Review;

/**
 * Class ProductTest
 * @package Lovata\ReviewsShopaholic\Tests\Unit\Models
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @mixin \PHPUnit\Framework\Assert
 */
class ProductTest extends CommonTest
{
    protected $sModelClass;

    /**
     * ProductTest constructor.
     */
    public function __construct()
    {
        $this->sModelClass = Product::class;
        parent::__construct();
    }

    /**
     * Check model "review" relation config
     */
    public function testHasReviewRelation()
    {
        $sErrorMessage = $this->sModelClass.' model has not correct "review" relation config';

        /** @var Product $obModel */
        $obModel = new Product();
        self::assertNotEmpty($obModel->hasMany, $sErrorMessage);
        self::assertArrayHasKey('review', $obModel->hasMany, $sErrorMessage);
        self::assertEquals(Review::class, array_shift($obModel->hasMany['review']), $sErrorMessage);
    }
}