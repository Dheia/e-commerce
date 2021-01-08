<?php namespace Lovata\AccessoriesShopaholic\Tests\Unit\Models;

use Lovata\Toolbox\Tests\CommonTest;

use Lovata\Shopaholic\Models\Product;

/**
 * Class ProductTest
 * @package Lovata\AccessoriesShopaholic\Tests\Unit\Models
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
        $sErrorMessage = $this->sModelClass.' model has not correct "accessory" relation config';

        /** @var Product $obModel */
        $obModel = new Product();
        self::assertNotEmpty($obModel->belongsToMany, $sErrorMessage);
        self::assertArrayHasKey('accessory', $obModel->belongsToMany, $sErrorMessage);
        self::assertEquals(Product::class, array_shift($obModel->belongsToMany['accessory']), $sErrorMessage);
    }
}