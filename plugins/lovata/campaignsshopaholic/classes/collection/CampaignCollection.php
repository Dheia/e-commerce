<?php namespace Lovata\CampaignsShopaholic\Classes\Collection;

use Lovata\Toolbox\Classes\Collection\ElementCollection;

use Lovata\CampaignsShopaholic\Classes\Item\CampaignItem;
use Lovata\CampaignsShopaholic\Classes\Store\CampaignListStore;

/**
 * Class CampaignCollection
 * @package Lovata\CampaignsShopaholic\Classes\Collection
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class CampaignCollection extends ElementCollection
{
    const ITEM_CLASS = CampaignItem::class;

    /**
     * Apply filter by promo block ID
     * @param int $iPromoBlockID
     * @return $this
     */
    public function promoBlock($iPromoBlockID)
    {
        $arElementIDList = CampaignListStore::instance()->promo_block->get($iPromoBlockID);

        return $this->intersect($arElementIDList);
    }
}
