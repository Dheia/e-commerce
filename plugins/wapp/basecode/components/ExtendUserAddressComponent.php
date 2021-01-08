<?php namespace Wapp\Basecode\Components;

use Illuminate\Support\Facades\Input;
use Kharanenka\Helper\Result;
use Lovata\OrdersShopaholic\Components\UserAddress;
use Lovata\Toolbox\Classes\Helper\UserHelper;
use Lovata\OrdersShopaholic\Models\UserAddress as UserAddressModel;

class ExtendUserAddressComponent extends UserAddress
{

    public function subscribe()
    {
        UserAddress::extend(function ($component) {
            $component->addDynamicMethod('onAddAddress', function () use ($component) {
                $iUserID = UserHelper::instance()->getUserId();
                $this->checkingFavorites($iUserID);
                $service = new UserAddress();
                $service->onAdd();
            });

            $component->addDynamicMethod('onFavoriteAddress', function () use ($component) {
                $arAddressIDList = Input::get('id');
                $iUserID = UserHelper::instance()->getUserId();
                if (empty($arAddressIDList) || empty($iUserID)) {
                    $sMessage = Lang::get('lovata.toolbox::lang.message.e_not_correct_request');
                    return Result::setFalse()->setMessage($sMessage)->get();
                }

                if (!is_array($arAddressIDList)) {
                    $arAddressIDList = [$arAddressIDList];
                }

                $this->checkingFavorites($iUserID);

                foreach ($arAddressIDList as $iAddressID) {
                    //Find address object by ID
                    $obAddress = UserAddressModel::getByUser($iUserID)->find($iAddressID);
                    if (empty($obAddress)) {
                        continue;
                    }
                    if ($obAddress->is_favorite == true) {
                        $obAddress->is_favorite = false;
                    } elseif ($obAddress->is_favorite == false) {
                        $obAddress->is_favorite = true;
                    }
                    $obAddress->save();
                }

                return Result::get();
            });
        });
    }

    /**
     * Check favorite address in array and set false
     */

    public function checkingFavorites($iUserID)
    {
        $obAddressList = UserAddressModel::getByUser($iUserID)->get();
        foreach ($obAddressList as $obAddress) {
            if (empty($obAddress)) {
                continue;
            }
            if ($obAddress->is_favorite == true) {
                $obAddress->is_favorite = false;
                $obAddress->save();
            }
        }
    }
}
