<?php namespace Lovata\ViewedProductsShopaholic\Classes\Event;

use Lovata\Toolbox\Classes\Helper\UserHelper;
use Lovata\ViewedProductsShopaholic\Classes\Helper\ViewedProductHelper;

/**
 * Class ExtendUserModel
 * @package Lovata\ViewedProductsShopaholic\Classes\Event
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendUserModel
{
    /**
     * Add listeners
     */
    public function subscribe()
    {
        $sUserModel = UserHelper::instance()->getUserModel();
        if (empty($sUserModel)) {
            return;
        }

        $sUserModel::extend(function ($obUser) {
            /** @var \Lovata\Buddies\Models\User|\RainLab\User\Models\User */
            $obUser->addJsonable(ViewedProductHelper::FIELD_NAME);
        });
    }
}
