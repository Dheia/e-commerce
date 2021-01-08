<?php namespace Wapp\Ascopy;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public $require = [
        'RainLab.Blog',
        'Wapp.BaseCode'
    ];

    public function pluginDetails()
    {
        return [
            'name'        => 'postdate',
            'description' => 'postdate wapp',
            'author'      => 'Wapp',
            'icon'        => 'icon-file'
        ];
    }

    public function boot()
    {
    }
}
