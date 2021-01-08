<?php namespace Wapp\Basecode\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Contracts\Logging\Log;
use Wapp\Basecode\Models\Settings;

class SiteSetting extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'SiteSettings',
            'description' => 'Set your home page',
            'author'      => 'Wapp',
            'icon'        => 'icon-leaf'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function registerComponents()
    {

        return [
            'Wapp\BaseCode\Components\SiteSetting' => 'Settings'
        ];
    }

    public function registerSettings()
    {
        return [
            'config' => [
                'label'       => 'SiteSetting',
                'icon'        => 'icon-folder',
                'description' => 'Setting for site(header,footer and oth.)',
                'class'       => 'Wapp\Basecode\Models\Settings',
                'permissions' => ['wapp.basecode.*'],
                'order'       => 600
            ]
        ];
    }


    public function registerPermissions()
    {
        return [
            'wapp.basecode.some_permission' => [
                'tab' => 'BaseCode',
                'label' => 'Some permission'
            ],
        ];
    }

    public function get($value)
    {
        $settings = new Settings;
        return $settings->getValue($value);
    }

    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'basecode' => [
                'label'       => 'Basecode',
                'url'         => Backend::url('wapp/basecode/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['wapp.basecode.*'],
                'order'       => 500,
            ],
        ];
    }

    private function addEventListener()
    {
        //
    }
}
