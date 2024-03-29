<?php namespace Hambern\Featuredfiles;

use System\Classes\PluginBase;
use RainLab\Blog\Models\Post as PostModel;

class Plugin extends PluginBase
{
    public $require = ['RainLab.Blog'];

    public function pluginDetails()
    {
        return [
            'name'        => 'hambern.featuredfiles::lang.plugin.name',
            'description' => 'hambern.featuredfiles::lang.plugin.description',
            'author'      => 'Hambern',
            'icon'        => 'icon-file'
        ];
    }

    public function boot()
    {
        PostModel::extend(function ($model) {
            $model->attachMany['featured_files'] = [
                'System\Models\File', 'order' => 'sort_order', 'delete' => true
            ];
        });
    }
}
