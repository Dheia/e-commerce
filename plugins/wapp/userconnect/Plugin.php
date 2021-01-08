<?php

namespace Wapp\UserConnect;

use Backend;
use System\Classes\PluginBase;
use Event;
use Wapp\Userconnect\Components\SubscriptionForm;

/**
 * UserConnect Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = [
        'Rainlab.Translate'
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'wapp.userconnect::lang.plugin.name',
            'description' => 'wapp.userconnect::lang.plugin.description',
            'author'      => 'Wapp',
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            SubscriptionForm::class => 'subscriptionForm'
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'wapp.userconnect.manage_settings' => [
                'tab' => 'wapp.userconnect::lang.plugin.name',
                'label' => 'wapp.userconnect::lang.permissions.manage_settings'
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'wapp.userconnect::lang.settings.label',
                'description' => 'wapp.userconnect::lang.settings.description',
                'icon'        => 'icon-cog',
                'class'       => 'Wapp\UserConnect\Models\Settings',
                'order'       => 500,
                'keywords'    => 'userconnect subscriptions'
            ]
        ];
    }


    public function registerNavigation()
    {
        return [
            'userconnect' => [
                'label'       => 'wapp.userconnect::lang.plugin.name',
                'url'         => Backend::url('wapp/userconnect/subscriptions'),
                'permissions' => ['wapp.userconnect.manage_settings'],
                'iconSvg'     => 'plugins/wapp/userconnect/assets/images/userconnect.svg',
                'sideMenu' => [
                    'subscriptions' => [
                        'label'       => 'wapp.userconnect::lang.subscriptions.menu_label',
                        'icon'        => 'icon-volume-up',
                        'url'         => Backend::url('wapp/userconnect/subscriptions'),
                    ],
                    'subscribers' => [
                        'label'       => 'wapp.userconnect::lang.subscribers.menu_label',
                        'icon'        => 'icon-users',
                        'url'         => Backend::url('wapp/userconnect/subscribers'),
                    ],
                    'categories' => [
                        'label'       => 'wapp.userconnect::lang.categories.menu_label',
                        'icon'        => 'icon-list',
                        'url'         => Backend::url('wapp/userconnect/categories'),
                    ],
                    'settings' => [
                        'label'       => 'wapp.userconnect::lang.settings.menu_label',
                        'icon'        => 'icon-cog',
                        'url'         => Backend::url('system/settings/update/wapp/userconnect/settings'),
                        'permissions' => ['wapp.userconnect.manage_settings'],
                    ]
                ]
            ]
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'wapp.userconnect::mail.verify_subscriber',
        ];
    }
}
