<?php namespace Lovata\ViewedProductsShopaholic\Tests\Unit\Collection;

use Event;
use System\Classes\PluginManager;
use Lovata\Toolbox\Tests\CommonTest;
use Lovata\Toolbox\Classes\Helper\UserHelper;

use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\ViewedProductsShopaholic\Classes\Helper\ViewedProductHelper;

/**
 * Class ProductCollectionTest
 * @package Lovata\ViewedProductsShopaholic\Tests\Unit\Collection
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 *
 * @mixin \PHPUnit\Framework\Assert
 */
class ProductCollectionTest extends CommonTest
{
    /** @var  Product */
    protected $obElement;

    /** @var  \Lovata\Buddies\Models\User */
    protected $obUser;

    protected $arCreateData = [
        'active' => true,
        'name'   => 'name',
        'slug'   => 'slug',
    ];

    protected $arUserData = [
        'email'                 => 'email@email.com',
        'password'              => 'test',
        'password_confirmation' => 'test',
    ];

    /**
     * Check "add" to viewed products method
     */
    public function testAddToViewedProducts()
    {
        $this->createTestData();
        if(empty($this->obElement)) {
            return;
        }

        if (!empty($this->obUser)) {
            \Lovata\Buddies\Facades\AuthHelper::logout();
        }

        $sErrorMessage = 'Add to viewed list method is not correct';

        //Check collection
        $obProductList = ProductCollection::make()->viewed();

        self::assertInstanceOf(ProductCollection::class, $obProductList);
        self::assertEquals(true, $obProductList->isEmpty(), $sErrorMessage);

        //Add product to viewed list
        /** @var ViewedProductHelper $obViewedProductHelper */
        $obViewedProductHelper = app(ViewedProductHelper::class);
        $obViewedProductHelper->add($this->obElement->id - 1);

        //Check collection
        $obProductList = ProductCollection::make()->viewed();
        self::assertEquals([$this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);

        //Check uniques
        $obViewedProductHelper->add($this->obElement->id - 1);
        $obProductList = ProductCollection::make()->viewed();
        self::assertEquals([$this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);

        if (empty($this->obUser)) {
            return;
        }

        $this->checkAddToViewedProductsWithLogin();
    }

    /**
     * Check "add" to viewed products method (with login)
     */
    public function checkAddToViewedProductsWithLogin()
    {
        $sErrorMessage = 'Add to viewed list method is not correct';

        \Lovata\Buddies\Facades\AuthHelper::login($this->obUser);

        $obProductList = ProductCollection::make()->viewed();
        self::assertEquals([$this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);

        \Lovata\Buddies\Facades\AuthHelper::logout();

        $obProductList = ProductCollection::make()->viewed();
        self::assertEquals(true, $obProductList->isEmpty(), $sErrorMessage);

        //Add product to viewed list
        /** @var ViewedProductHelper $obViewedProductHelper */
        $obViewedProductHelper = app(ViewedProductHelper::class);
        $obViewedProductHelper->add($this->obElement->id);

        //Check collection
        $obProductList = ProductCollection::make()->viewed();
        self::assertEquals([$this->obElement->id], $obProductList->getIDList(), $sErrorMessage);

        \Lovata\Buddies\Facades\AuthHelper::login($this->obUser);

        //Check collection
        $obProductList = ProductCollection::make()->viewed();
        self::assertEquals([$this->obElement->id, $this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);
    }

    /**
     * Check "add" to viewed products method
     */
    public function testOpenProductPageEvent()
    {
        $this->createTestData();
        if(empty($this->obElement)) {
            return;
        }

        if (!empty($this->obUser)) {
            \Lovata\Buddies\Facades\AuthHelper::logout();
        }

        $sErrorMessage = 'Event shopaholic.product.open is not work';

        /** @var ViewedProductHelper $obViewedProductHelper */
        $obViewedProductHelper = app(ViewedProductHelper::class);
        $obViewedProductHelper->clear();

        //Check collection
        $obProductList = ProductCollection::make()->viewed();

        self::assertInstanceOf(ProductCollection::class, $obProductList);
        self::assertEquals(true, $obProductList->isEmpty(), $sErrorMessage);

        Event::fire('shopaholic.product.open', $this->obElement);

        //Check collection
        $obProductList = ProductCollection::make()->viewed();
        self::assertEquals([$this->obElement->id], $obProductList->getIDList(), $sErrorMessage);
    }


    /**
     * Check "remove" from viewed products list method
     */
    public function testRemoveFromViewedProducts()
    {
        $this->createTestData();
        if(empty($this->obElement)) {
            return;
        }

        if (!empty($this->obUser)) {
            \Lovata\Buddies\Facades\AuthHelper::logout();
        }

        PluginManager::instance()->refreshPlugin('Lovata.ViewedProductsShopaholic');

        /** @var ViewedProductHelper $obViewedProductHelper */
        $obViewedProductHelper = app(ViewedProductHelper::class);
        $obViewedProductHelper->clear();

        $sErrorMessage = 'Remove from viewed products list method is not correct';

        //Check collection
        $obProductList = ProductCollection::make()->viewed();

        self::assertInstanceOf(ProductCollection::class, $obProductList);
        self::assertEquals(true, $obProductList->isEmpty(), $sErrorMessage);

        //Add product to viewed products
        $obViewedProductHelper->add($this->obElement->id - 1);
        $obViewedProductHelper->add($this->obElement->id);

        //Check collection
        $obProductList = ProductCollection::make()->viewed();
        self::assertEquals([$this->obElement->id, $this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);

        $obViewedProductHelper->remove($this->obElement->id - 1);
        $obProductList = ProductCollection::make()->viewed();
        self::assertEquals([$this->obElement->id], $obProductList->getIDList(), $sErrorMessage);

        if (empty($this->obUser)) {
            return;
        }

        $this->checkRemoveFromViewedProductsWithLogin();
    }

    /**
     * Check "remove" from viewed products list method (with login)
     */
    public function checkRemoveFromViewedProductsWithLogin()
    {
        $sErrorMessage = 'Remove from viewed products list method is not correct';

        \Lovata\Buddies\Facades\AuthHelper::login($this->obUser);

        //Add product to viewed products
        /** @var ViewedProductHelper $obViewedProductHelper */
        $obViewedProductHelper = app(ViewedProductHelper::class);
        $obViewedProductHelper->add($this->obElement->id - 1);

        //Check collection
        $obProductList = ProductCollection::make()->viewed();
        self::assertEquals([$this->obElement->id - 1, $this->obElement->id], $obProductList->getIDList(), $sErrorMessage);

        $obViewedProductHelper->remove($this->obElement->id);

        //Check collection
        $obProductList = ProductCollection::make()->viewed();
        self::assertEquals([$this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);
    }

    /**
     * Check "clear" viewed products list method
     */
    public function testClearViewedProductsList()
    {
        $this->createTestData();
        if(empty($this->obElement)) {
            return;
        }

        if (!empty($this->obUser)) {
            \Lovata\Buddies\Facades\AuthHelper::logout();
        }

        PluginManager::instance()->refreshPlugin('Lovata.ViewedProductsShopaholic');

        /** @var ViewedProductHelper $obViewedProductHelper */
        $obViewedProductHelper = app(ViewedProductHelper::class);
        $obViewedProductHelper->clear();

        $sErrorMessage = 'Clear viewed products list method is not correct';

        //Check collection
        $obProductList = ProductCollection::make()->viewed();

        self::assertInstanceOf(ProductCollection::class, $obProductList);
        self::assertEquals(true, $obProductList->isEmpty(), $sErrorMessage);

        //Add product to viewed products
        $obViewedProductHelper->add($this->obElement->id - 1);
        $obViewedProductHelper->add($this->obElement->id);

        //Check collection
        $obProductList = ProductCollection::make()->viewed();
        self::assertEquals([$this->obElement->id, $this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);

        $obViewedProductHelper->clear();
        $obProductList = ProductCollection::make()->viewed();
        self::assertEquals(true, $obProductList->isEmpty(), $sErrorMessage);

        if (empty($this->obUser)) {
            return;
        }

        $this->checkClearViewedProductsWithLogin();
    }

    /**
     * Check "clear" viewed products list method (with login)
     */
    public function checkClearViewedProductsWithLogin()
    {
        $sErrorMessage = 'Clear viewed products list method is not correct';

        \Lovata\Buddies\Facades\AuthHelper::login($this->obUser);

        //Add product to viewed products list
        /** @var ViewedProductHelper $obViewedProductHelper */
        $obViewedProductHelper = app(ViewedProductHelper::class);
        $obViewedProductHelper->add($this->obElement->id - 1);
        $obViewedProductHelper->add($this->obElement->id);

        //Check collection
        $obProductList = ProductCollection::make()->viewed();
        self::assertEquals([$this->obElement->id, $this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);

        $obViewedProductHelper->clear();

        //Check collection
        $obProductList = ProductCollection::make()->viewed();
        self::assertEquals(true, $obProductList->isEmpty(), $sErrorMessage);
    }

    /**
     * Create test data
     */
    protected function createTestData()
    {
        //Create product data
        $arCreateData = $this->arCreateData;
        Product::create($arCreateData);

        $arCreateData['slug'] = $arCreateData['slug'].'1';
        $this->obElement = Product::create($arCreateData);

        $sUserPluginName = UserHelper::instance()->getPluginName();
        if ($sUserPluginName != 'Lovata.Buddies') {
            return;
        }

        $this->obUser = \Lovata\Buddies\Models\User::create($this->arUserData);
        $this->obUser = \Lovata\Buddies\Models\User::find($this->obUser->id);
    }
}
