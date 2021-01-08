<?php namespace Wapp\Postdate;

use System\Classes\PluginBase;
use wapp\postdate\event\ExtendFeaturedFilesModel;
use Wapp\Postdate\Event\ExtendPostModel;
use Event;
use wapp\postdate\event\ExtendSimpleGalleryModel;

class Plugin extends PluginBase
{
    public $require = ['RainLab.Blog'];

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
        $this->addEventListener();
    }

    public function addEventListener()
    {
        Event::subscribe(ExtendPostModel::class);
        Event::subscribe(ExtendSimpleGalleryModel::class);
        Event::subscribe(ExtendFeaturedFilesModel::class);
    }
}
