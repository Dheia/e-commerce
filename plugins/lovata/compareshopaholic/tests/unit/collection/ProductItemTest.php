<?php namespace Lovata\CompareShopaholic\Tests\Unit\Collection;

use System\Classes\PluginManager;
use Lovata\Toolbox\Tests\CommonTest;
use Lovata\Toolbox\Classes\Helper\UserHelper;

use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\CompareShopaholic\Classes\Helper\CompareHelper;

/**
 * Class ProductCollectionTest
 * @package Lovata\CompareShopaholic\Tests\Unit\Collection
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
     * Check "add" compare method
     */
    public function testAddToCompare()
    {
        $this->createTestData();
        if(empty($this->obElement)) {
            return;
        }

        if (!empty($this->obUser)) {
            \Lovata\Buddies\Facades\AuthHelper::logout();
        }

        $sErrorMessage = 'Add to compare method is not correct';

        //Check collection
        $obProductList = ProductCollection::make()->compare();

        self::assertInstanceOf(ProductCollection::class, $obProductList);
        self::assertEquals(true, $obProductList->isEmpty(), $sErrorMessage);

        //Add product to compare
        /** @var CompareHelper $obCompareHelper */
        $obCompareHelper = app(CompareHelper::class);
        $obCompareHelper->add($this->obElement->id - 1);

        //Check collection
        $obProductList = ProductCollection::make()->compare();
        self::assertEquals([$this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);

        //Check uniques
        $obCompareHelper->add($this->obElement->id - 1);
        $obProductList = ProductCollection::make()->compare();
        self::assertEquals([$this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);

        if (empty($this->obUser)) {
            return;
        }

        $this->checkAddToCompareWithLogin();
    }

    /**
     * Check "add" compare method (with login)
     */
    public function checkAddToCompareWithLogin()
    {
        $sErrorMessage = 'Add to compare method is not correct';

        \Lovata\Buddies\Facades\AuthHelper::login($this->obUser);

        $obProductList = ProductCollection::make()->compare();
        self::assertEquals([$this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);

        \Lovata\Buddies\Facades\AuthHelper::logout();

        $obProductList = ProductCollection::make()->compare();
        self::assertEquals(true, $obProductList->isEmpty(), $sErrorMessage);

        //Add product to compare
        /** @var CompareHelper $obCompareHelper */
        $obCompareHelper = app(CompareHelper::class);
        $obCompareHelper->add($this->obElement->id);

        //Check collection
        $obProductList = ProductCollection::make()->compare();
        self::assertEquals([$this->obElement->id], $obProductList->getIDList(), $sErrorMessage);

        \Lovata\Buddies\Facades\AuthHelper::login($this->obUser);

        //Check collection
        $obProductList = ProductCollection::make()->compare();
        self::assertEquals([$this->obElement->id, $this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);
    }

    /**
     * Check "remove" compare method
     */
    public function testRemoveFromCompare()
    {
        $this->createTestData();
        if(empty($this->obElement)) {
            return;
        }

        if (!empty($this->obUser)) {
            \Lovata\Buddies\Facades\AuthHelper::logout();
        }

        PluginManager::instance()->refreshPlugin('Lovata.CompareShopaholic');

        /** @var CompareHelper $obCompareHelper */
        $obCompareHelper = app(CompareHelper::class);
        $obCompareHelper->clear();

        $sErrorMessage = 'Remove from compare method is not correct';

        //Check collection
        $obProductList = ProductCollection::make()->compare();

        self::assertInstanceOf(ProductCollection::class, $obProductList);
        self::assertEquals(true, $obProductList->isEmpty(), $sErrorMessage);

        //Add product to compare
        $obCompareHelper->add($this->obElement->id - 1);
        $obCompareHelper->add($this->obElement->id);

        //Check collection
        $obProductList = ProductCollection::make()->compare();
        self::assertEquals([$this->obElement->id, $this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);

        $obCompareHelper->remove($this->obElement->id - 1);
        $obProductList = ProductCollection::make()->compare();
        self::assertEquals([$this->obElement->id], $obProductList->getIDList(), $sErrorMessage);

        if (empty($this->obUser)) {
            return;
        }

        $this->checkRemoveFromCompareWithLogin();
    }

    /**
     * Check "remove" compare method (with login)
     */
    public function checkRemoveFromCompareWithLogin()
    {
        $sErrorMessage = 'Add to compare method is not correct';

        \Lovata\Buddies\Facades\AuthHelper::login($this->obUser);

        //Add product to compare
        /** @var CompareHelper $obCompareHelper */
        $obCompareHelper = app(CompareHelper::class);
        $obCompareHelper->add($this->obElement->id - 1);

        //Check collection
        $obProductList = ProductCollection::make()->compare();
        self::assertEquals([$this->obElement->id - 1, $this->obElement->id], $obProductList->getIDList(), $sErrorMessage);

        $obCompareHelper->remove($this->obElement->id);

        //Check collection
        $obProductList = ProductCollection::make()->compare();
        self::assertEquals([$this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);
    }

    /**
     * Check "clear" compare method
     */
    public function testClearCompareList()
    {
        $this->createTestData();
        if(empty($this->obElement)) {
            return;
        }

        if (!empty($this->obUser)) {
            \Lovata\Buddies\Facades\AuthHelper::logout();
        }

        PluginManager::instance()->refreshPlugin('Lovata.CompareShopaholic');

        /** @var CompareHelper $obCompareHelper */
        $obCompareHelper = app(CompareHelper::class);
        $obCompareHelper->clear();

        $sErrorMessage = 'Remove from compare method is not correct';

        //Check collection
        $obProductList = ProductCollection::make()->compare();

        self::assertInstanceOf(ProductCollection::class, $obProductList);
        self::assertEquals(true, $obProductList->isEmpty(), $sErrorMessage);

        //Add product to compare
        $obCompareHelper->add($this->obElement->id - 1);
        $obCompareHelper->add($this->obElement->id);

        //Check collection
        $obProductList = ProductCollection::make()->compare();
        self::assertEquals([$this->obElement->id, $this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);

        $obCompareHelper->clear();
        $obProductList = ProductCollection::make()->compare();
        self::assertEquals(true, $obProductList->isEmpty(), $sErrorMessage);

        if (empty($this->obUser)) {
            return;
        }

        $this->checkClearCompareWithLogin();
    }

    /**
     * Check "clear" compare method (with login)
     */
    public function checkClearCompareWithLogin()
    {
        $sErrorMessage = 'Add to compare method is not correct';

        \Lovata\Buddies\Facades\AuthHelper::login($this->obUser);

        //Add product to compare
        /** @var CompareHelper $obCompareHelper */
        $obCompareHelper = app(CompareHelper::class);
        $obCompareHelper->add($this->obElement->id - 1);
        $obCompareHelper->add($this->obElement->id);

        //Check collection
        $obProductList = ProductCollection::make()->compare();
        self::assertEquals([$this->obElement->id, $this->obElement->id - 1], $obProductList->getIDList(), $sErrorMessage);

        $obCompareHelper->clear();

        //Check collection
        $obProductList = ProductCollection::make()->compare();
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