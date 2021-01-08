<?php namespace Lovata\SubscriptionsShopaholic\Classes\Event\User;

use Lovata\Toolbox\Classes\Helper\UserHelper;

use Lovata\SubscriptionsShopaholic\Models\SubscriptionAccess;
use Lovata\SubscriptionsShopaholic\Classes\Collection\SubscriptionAccessCollection;

/**
 * Class UserModelHandler
 * @package Lovata\SubscriptionsShopaholic\Classes\Event\User
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class UserModelHandler
{
    /**
     * Add listeners
     */
    public function subscribe()
    {
        $sUserModel = UserHelper::instance()->getUserModel();
        $sPluginName = UserHelper::instance()->getPluginName();
        if (empty($sUserModel)) {
            return;
        }

        $sUserModel::extend(function ($obUser) {
            /** @var \Lovata\Buddies\Models\User $obUser */
            $obUser->hasMany['subscription_access'] = [
                SubscriptionAccess::class,
            ];

            $this->addCheckAccessToSubscriptionMethod($obUser);
            $this->addFindAccessToSubscriptionMethod($obUser);
        });

        if ($sPluginName != 'Lovata.Buddies') {
            return;
        }

        $sItemClass = 'Lovata\Buddies\Classes\Item\UserItem';
        $sItemClass::extend(function ($obUserItem) {
            /** @var \Lovata\Buddies\Classes\Item\UserItem $obUserItem */
            $this->addCheckAccessToSubscriptionMethod($obUserItem);
            $this->addFindAccessToSubscriptionMethodItemObject($obUserItem);
            $this->addSubscriptionAccessAttribute($obUserItem);
        });
    }

    /**
     * Add checkAccessToSubscription method to User model
     * @param \Lovata\Buddies\Models\User|\Lovata\Buddies\Classes\Item\UserItem $obUser
     */
    protected function addCheckAccessToSubscriptionMethod($obUser)
    {
        $obUser->addDynamicMethod('checkAccessToSubscription', function ($iProductID, $iElementID = null, $sElementType = null) use ($obUser) {

            $obAccess = $obUser->findAccessToSubscription($iProductID, $iElementID, $sElementType);
            $bResult = !empty($obAccess) && $obAccess->isActive();

            return $bResult;
        });
    }

    /**
     * Add checkFindToSubscription method to User model
     * @param \Lovata\Buddies\Models\User|\Lovata\Buddies\Classes\Item\UserItem $obUser
     */
    protected function addFindAccessToSubscriptionMethod($obUser)
    {
        $obUser->addDynamicMethod('findAccessToSubscription', function ($iProductID, $iElementID = null, $sElementType = null) use ($obUser) {
            if (empty($iElementID) || empty($sElementType)) {
                $obAccess = SubscriptionAccess::getByUser($obUser->id)->getByProduct($iProductID)->first();
            } else {
                $obAccess = SubscriptionAccess::getByUser($obUser->id)->getByProduct($iProductID)->getByElementID($iElementID)->getByElementType($sElementType)->first();
            }

            return $obAccess;
        });
    }

    /**
     * Add findAccessToSubscription method to User model
     * @param \Lovata\Buddies\Classes\Item\UserItem $obUserItem
     */
    protected function addFindAccessToSubscriptionMethodItemObject($obUserItem)
    {
        $obUserItem->addDynamicMethod('findAccessToSubscription', function ($iProductID, $iElementID = null, $sElementType = null) use ($obUserItem) {
            $obAccessItem = SubscriptionAccessCollection::make()->findByProduct($iProductID, $obUserItem->id, $iElementID, $sElementType);

            return $obAccessItem;
        });
    }

    /**
     * Add subscription_access attribute to UsrItem object
     * @param \Lovata\Buddies\Classes\Item\UserItem $obUserItem
     */
    protected function addSubscriptionAccessAttribute($obUserItem)
    {
        $obUserItem->addDynamicMethod('getSubscriptionAccessAttribute', function ($obUserItem) {
            /** @var \Lovata\Buddies\Classes\Item\UserItem $obUserItem */
            $obAccessList = SubscriptionAccessCollection::make()->user($obUserItem->id);

            return $obAccessList;
        });
    }
}
