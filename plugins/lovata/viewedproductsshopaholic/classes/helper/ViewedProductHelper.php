<?php namespace Lovata\ViewedProductsShopaholic\Classes\Helper;

use Lovata\Shopaholic\Models\Settings;
use Lovata\Toolbox\Classes\Storage\UserStorage;
use Lovata\Toolbox\Classes\Storage\SessionUserStorage;

/**
 * Class ViewedProductHelper
 * @package Lovata\ViewedProductsShopaholic\Classes\Helper
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ViewedProductHelper
{
    const FIELD_NAME = 'viewed_products';
    const DEFAULT_LIMIT = 10;

    /**
     * Add product in viewed products list
     * @param int $iProductID
     */
    public function add($iProductID)
    {
        if (empty($iProductID)) {
            return;
        }

        $obUserStorage = $this->getUserStorage();
        $obUserStorage->addToList(self::FIELD_NAME, $iProductID);

        //Get product ID list
        $arProductIDList = $obUserStorage->getList(self::FIELD_NAME);

        //Get limit
        $iProductLimit = Settings::getValue('viewed_product_limit', self::DEFAULT_LIMIT);
        if (count($arProductIDList) <= $iProductLimit) {
            return;
        }

        //Get new product ID list and save new array
        $arProductIDList = array_slice($arProductIDList, 0, $iProductLimit);
        $obUserStorage->put(self::FIELD_NAME, $arProductIDList);
    }

    /**
     * Remove product from viewed products list
     * @param int $iProductID
     */
    public function remove($iProductID)
    {
        if (empty($iProductID)) {
            return;
        }

        $obUserStorage = $this->getUserStorage();
        $obUserStorage->removeFromList(self::FIELD_NAME, $iProductID);
    }

    /**
     * Get viewed products list
     * @return array
     */
    public function getList()
    {
        $obUserStorage = $this->getUserStorage();
        $arProductIDList = $obUserStorage->getList(self::FIELD_NAME);

        return $arProductIDList;
    }

    /**
     * Clear viewed products list
     */
    public function clear()
    {
        $obUserStorage = $this->getUserStorage();
        $obUserStorage->clear(self::FIELD_NAME);
    }

    /**
     * Get user storage object
     * @return UserStorage
     */
    protected function getUserStorage()
    {
        /** @var UserStorage $obUserStorage */
        $obUserStorage = app(UserStorage::class);
        $obUserStorage->setDefaultStorage(SessionUserStorage::class);

        return $obUserStorage;
    }
}