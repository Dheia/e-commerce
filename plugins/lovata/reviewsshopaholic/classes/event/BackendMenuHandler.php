<?php namespace Lovata\ReviewsShopaholic\Classes\Event;

use Backend;

/**
 * Class BackendMenuHandler
 * @package Lovata\ReviewsShopaholic\Classes\Event
 */
class BackendMenuHandler
{
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        $obEvent->listen('backend.menu.extendItems', function($obManager) {
            $this->addMenuItems($obManager);
        });
    }

    /**
     * Add menu items
     * @param \Backend\Classes\NavigationManager $obManager
     */
    public function addMenuItems($obManager)
    {
        $obManager->addSideMenuItems('Lovata.Shopaholic', 'shopaholic-menu-main', [
            'shopaholic-menu-reviews' => [
                'label'         => 'lovata.reviewsshopaholic::lang.menu.reviews',
                'url'           => Backend::url('lovata/reviewsshopaholic/reviews'),
                'icon'          => 'icon-commenting',
                'permissions'   => ['shopaholic-menu-reviews'],
                'order'         => 350,
            ],
        ]);
    }
}
