<?php namespace Wapp\BaseCode\Classes\Event\Category;

use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Models\Settings;

/**
 * Class CategoryModelHandler
 * @package Lovata\BaseCode\Classes\Event\Category
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class CategoryModelHandler
{
    /**
     * Add listeners
     */
    public function subscribe()
    {
        Category::extend(function ($obCategory) {
            /** @var Category $obCategory */
           $obCategory->attachOne['icon'] = 'System\Models\File';

           $obCategory->addCachedField('icon');
        });
    }

    /**
     * Before creating event handler
     */
    public function beforeCreate()
    {
        $this->setDefaultLeftAndRight();
    }
}
