<?php namespace Lovata\ReviewsShopaholic\Tests\Unit\Models;

include_once __DIR__.'/../../../../toolbox/vendor/autoload.php';
include_once __DIR__.'/../../../../../../tests/PluginTestCase.php';

use PluginTestCase;
use Lovata\Shopaholic\Models\Product;
use Lovata\ReviewsShopaholic\Models\Review;

/**
 * Class ReviewTest
 * @package Lovata\ReviewsShopaholic\Tests\Unit\Models
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @mixin \PHPUnit\Framework\Assert
 */
class ReviewTest extends PluginTestCase
{
    protected $sModelClass;

    /**
     * ReviewTest constructor.
     */
    public function __construct()
    {
        $this->sModelClass = Review::class;
        parent::__construct();
    }

    /**
     * Check model "product" relation config
     */
    public function testHasProductRelation()
    {
        $sErrorMessage = $this->sModelClass.' model has not correct "product" relation config';

        /** @var Review $obModel */
        $obModel = new Review();
        self::assertNotEmpty($obModel->belongsTo, $sErrorMessage);
        self::assertArrayHasKey('product', $obModel->belongsTo, $sErrorMessage);
        self::assertEquals(Product::class, array_shift($obModel->belongsTo['product']), $sErrorMessage);
    }
}