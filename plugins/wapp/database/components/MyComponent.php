<?php namespace Wapp\Database\Components;

use Cms\Classes\ComponentBase;

class MyComponent extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'MyComponent Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
}
