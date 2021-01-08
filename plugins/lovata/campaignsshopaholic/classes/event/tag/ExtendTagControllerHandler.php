<?php namespace Lovata\CampaignsShopaholic\Classes\Event\Tag;

use Lovata\Toolbox\Classes\Event\AbstractExtendRelationConfigHandler;

use System\Classes\PluginManager;

/**
 * Class ExtendTagControllerHandler
 * @package Lovata\CampaignsShopaholic\Classes\Event\Tag
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendTagControllerHandler extends AbstractExtendRelationConfigHandler
{
    /**
     * Add listeners
     */
    public function subscribe()
    {
        if (!PluginManager::instance()->hasPlugin('Lovata.TagsShopaholic')) {
            return;
        }

        parent::subscribe();
    }

    /**
     * Get path to config file
     * @return string
     */
    protected function getConfigPath() : string
    {
        return '$/lovata/campaignsshopaholic/config/campaign_config_relation.yaml';
    }

    /**
     * Get controller class name
     * @return string
     */
    protected function getControllerClass() : string
    {
        return \Lovata\TagsShopaholic\Controllers\Tags::class;
    }
}
