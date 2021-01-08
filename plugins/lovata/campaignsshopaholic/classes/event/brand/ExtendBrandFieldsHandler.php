<?php namespace Lovata\CampaignsShopaholic\Classes\Event\Brand;

use Lovata\Toolbox\Classes\Event\AbstractBackendFieldHandler;

use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Controllers\Brands;

/**
 * Class ExtendBrandFieldsHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\Brand
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendBrandFieldsHandler extends AbstractBackendFieldHandler
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
        return Brand::class;
    }

    /**
     * Get controller class name
     * @return string
     */
    protected function getControllerClass() : string
    {
        return Brands::class;
    }
}
