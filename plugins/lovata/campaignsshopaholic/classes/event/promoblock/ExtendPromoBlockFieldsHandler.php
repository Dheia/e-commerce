<?php namespace Lovata\CampaignsShopaholic\Classes\Event\PromoBlock;

use Lovata\Toolbox\Classes\Event\AbstractBackendFieldHandler;

use Lovata\Shopaholic\Models\PromoBlock;
use Lovata\Shopaholic\Controllers\PromoBlocks;

/**
 * Class ExtendPromoBlockFieldsHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\PromoBlock
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendPromoBlockFieldsHandler extends AbstractBackendFieldHandler
{
    /**
     * Extend form fields
     * @param \Backend\Widgets\Form $obWidget
     */
    protected function extendFields($obWidget)
    {
        $arAdditionFields = [
            'campaign' => [
                'type'    => 'partial',
                'tab'     => 'lovata.campaignsshopaholic::lang.menu.campaign',
                'path'    => '$/lovata/campaignsshopaholic/views/campaign.htm',
                'context' => ['update'],
            ],
        ];

        $obWidget->addTabFields($arAdditionFields);
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass() : string
    {
        return PromoBlock::class;
    }

    /**
     * Get controller class name
     * @return string
     */
    protected function getControllerClass() : string
    {
        return PromoBlocks::class;
    }
}
