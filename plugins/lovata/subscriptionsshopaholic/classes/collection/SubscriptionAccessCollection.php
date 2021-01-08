<?php namespace Lovata\SubscriptionsShopaholic\Classes\Collection;

use Lovata\Toolbox\Classes\Helper\UserHelper;
use Lovata\Toolbox\Classes\Collection\ElementCollection;

use Lovata\SubscriptionsShopaholic\Classes\Item\SubscriptionAccessItem;
use Lovata\SubscriptionsShopaholic\Classes\Store\SubscriptionAccessListStore;

/**
 * Class SubscriptionAccessCollection
 * @package Lovata\SubscriptionsShopaholic\Classes\Collection
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class SubscriptionAccessCollection extends ElementCollection
{
    const ITEM_CLASS = SubscriptionAccessItem::class;

    /**
     * Apply filter by user ID
     * @param int $iUserID
     * @return $this
     */
    public function user($iUserID = null)
    {
        if (empty($iUserID)) {
            $iUserID = UserHelper::instance()->getUserID();
        }

        if (empty($iUserID)) {
            return $this->clear();
        }

        $arResultIDList = SubscriptionAccessListStore::instance()->user->get($iUserID);

        return $this->intersect($arResultIDList);
    }

    /**
     * Apply filter by product ID
     * @param array|int $arProductIDList
     * @param int       $iUserID
     * @return $this
     */
    public function product($arProductIDList, $iUserID = null)
    {
        if (empty($arProductIDList)) {
            return $this->returnThis();
        }

        $arResultIDList = [];
        if (!is_array($arProductIDList)) {
            $arProductIDList = [$arProductIDList];
        }

        foreach ($arProductIDList as $iProductID) {
            $arResultIDList = array_merge($arResultIDList, SubscriptionAccessListStore::instance()->product->get($iProductID, $iUserID));
        }

        $arResultIDList = array_unique($arResultIDList);

        return $this->intersect($arResultIDList);
    }

    /**
     * Apply filter by element ID
     * @param int $iElementID
     * @param int $iUserID
     * @return $this
     */
    public function elementID($iElementID, $iUserID = null)
    {
        $arResultIDList = SubscriptionAccessListStore::instance()->element_id->get($iElementID, $iUserID);

        return $this->intersect($arResultIDList);
    }

    /**
     * Apply filter by element type
     * @param string $sElementType
     * @param int    $iUserID
     * @return $this
     */
    public function elementType($sElementType, $iUserID = null)
    {
        $arResultIDList = SubscriptionAccessListStore::instance()->element_type->get($sElementType, $iUserID);

        return $this->intersect($arResultIDList);
    }

    /**
     * Find access by product ID and user ID
     * @param int    $iProductID
     * @param int    $iUserID
     * @param int    $iElementID
     * @param string $sElementType
     * @return SubscriptionAccessItem
     */
    public function findByProduct($iProductID, $iUserID, $iElementID = null, $sElementType = null)
    {
        /** @var SubscriptionAccessItem $obAccessItem */
        if (!empty($iElementID) && !empty($sElementType)) {
            $obAccessItem = static::make()->product($iProductID, $iUserID)->elementID($iElementID, $iUserID)->elementType($sElementType, $iUserID)->first();
        } else {
            $obAccessItem = static::make()->product($iProductID, $iUserID)->first();
        }

        return $obAccessItem;
    }

    /**
     * Apply filter by active access to subscriptions
     * @return $this
     */
    public function active()
    {
        if ($this->isEmpty()) {
            return $this->clear();
        }

        $arResultIDList = [];

        $arAccessList = $this->all();
        /** @var SubscriptionAccessItem $obAccessItem */
        foreach ($arAccessList as $obAccessItem) {
            if ($obAccessItem->isActive()) {
                $arResultIDList[] = $obAccessItem->id;
            }
        }

        return $this->intersect($arResultIDList);
    }
}
