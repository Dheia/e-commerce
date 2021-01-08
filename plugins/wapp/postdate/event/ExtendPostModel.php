<?php namespace wapp\postdate\event;

use PolloZen\SimpleGallery\Models\Gallery as SimpleGallery;
use RainLab\Blog\Models\Post;

class ExtendPostModel
{
    public function subscribe()
    {
        Post::extend(function ($model) {

            $model->attachMany['featured_results'] = [
                'System\Models\File', 'order' => 'sort_order', 'delete' => true
            ];
            $model->addFillable([
                'date_start',
                'date_end',
                'participants',
                'place',
                'is_region_main',
                'priority',
            ]);

            $model->addJsonable(['peoples']);

            $model->addDynamicMethod('getNewsIdOptions', function () use ($model) {
                return Post::all()->where('published', true)
                    ->lists('title', 'id');
            });
        });

        SimpleGallery::extend(function ($model) {
            $model->addFillable(['name', 'slug']);
        });


        $this->modifyComponent();
    }

    public function modifyComponent()
    {
        $modYamlFields = 'plugins/wapp/postdate/models/post/fields.yaml';
        $origYamlFields = 'plugins/rainlab/blog/models/post/fields.yaml';
        if (!file_exists($origYamlFields . '.bcp')) {
            //create backup and remove orig
            copy($origYamlFields, $origYamlFields . '.bcp');
            unlink($origYamlFields);
            //copy modify file to component
            copy($modYamlFields, $origYamlFields);
        }
    }
}
