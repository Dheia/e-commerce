<?php namespace wapp\postdate\event;

class ExtendFeaturedFilesModel
{
    public function subscribe()
    {
        $this->modifyComponent();
    }

    public function modifyComponent()
    {
        $modFile = 'plugins/wapp/postdate/models/featuredfiles/Plugin.php';
        $origFile = 'plugins/hambern/featuredfiles/Plugin.php';
        if (!file_exists($origFile . '.bcp')) {
            //create backup and remove orig
            copy($origFile, $origFile . '.bcp');
            unlink($origFile);
            //copy modify file to component
            copy($modFile, $origFile);
        }
    }
}
