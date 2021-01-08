<?php namespace Wapp\BaseCode\Classes\Event\UserAddress;

use Lovata\Ordersshopaholic\Models\UserAddress;

/**
 * Class ExtendUserAddressModel
 * @package Wapp\BaseCode\Classes\Event\UserAddress
 */
class ExtendUserAddressModel
{
    public function subscribe()
    {
        UserAddress::extend(function ($obUserAddress) {
            /** @var $obUserAddress UserAddress */
            $obUserAddress->addFillable(['is_favorite','apartment']);

            $obUserAddress->addCachedField(['is_favorite','apartment']);
        });
    }
}
