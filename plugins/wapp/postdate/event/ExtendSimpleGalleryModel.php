<?php namespace wapp\postdate\event;

use PolloZen\SimpleGallery\Models\Gallery as SimpleGallery;
use RainLab\Blog\Controllers\Posts as PostsController;
use RainLab\Blog\Models\Post;
use RainLab\Blog\Controllers\Posts as PostController;
use RainLab\Blog\Models\Post as PostModel;

class ExtendSimpleGalleryModel
{
    public function subscribe()
    {
        $this->modifyComponent();
    }

    public function modifyComponent()
    {
        $modFile = 'plugins/wapp/postdate/models/simplegallery/Plugin.php';
        $origFile = 'plugins/pollozen/simplegallery/Plugin.php';
        if (!file_exists($origFile . '.bcp')) {
            //create backup and remove orig
            copy($origFile, $origFile . '.bcp');
            unlink($origFile);
            //copy modify file to component
            copy($modFile, $origFile);
        }
    }
}
