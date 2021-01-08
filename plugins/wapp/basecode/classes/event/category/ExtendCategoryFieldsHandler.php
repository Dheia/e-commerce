<?php namespace Wapp\BaseCode\Classes\Event\Category;

use Lang;
use Lovata\Toolbox\Classes\Event\AbstractBackendFieldHandler;

use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Controllers\Categories;

/**
 * Class ExtendCategoryFieldsHandler
 * @package Lovata\BaseCode\Classes\Event\Category
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendCategoryFieldsHandler extends AbstractBackendFieldHandler
{
//    приоритет события
//    protected $iPriority = 15000;

    /**
     * Extend form fields
     * @param \Backend\Widgets\Form $obWidget
     */
    protected function extendFields($obWidget)
    {
        $arAdditionFields = [
            'icon' => [
                'label' => 'wapp.basecode::lang.field.icon',
                'type' => 'fileupload',
                'tab' => 'lovata.toolbox::lang.tab.images',
                'mode' => 'image',
                'fileTypes'=> 'svg',
]
        ];

        $obWidget->addTabFields($arAdditionFields);
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass(): string
    {
        return Category::class;
    }

    /**
     * Get controller class name
     * @return string
     */
    protected function getControllerClass(): string
    {
        return Categories::class;
    }
}
