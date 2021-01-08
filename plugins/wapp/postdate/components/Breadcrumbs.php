<?php namespace Wapp\Postdate\Components;

use Cms\Classes\ComponentBase;
use RainLab\Blog\Models\Category as CategoryModel;
use RainLab\Blog\Models\Post as PostModel;
class Breadcrumbs extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Breadcrumbs Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function getBreadcrumbs($url)
    {
        $arrUrl = parse_url($url);
        $urlPartsString = $arrUrl['path'];
        $urlParts = explode('/', $urlPartsString);
        $results[] = [
            'Главная' => '/',
        ];
        foreach($urlParts as $key => $urlPart){
            if($urlPart == 'regions'){
                $urlPart = 'regiony';
            }elseif($urlPart == 'team'){
                $urlPart = 'sbornaya';
            }elseif($urlPart == 'rules'){
                $urlPart = 'pravila';
            }
            $category = CategoryModel::where('slug', $urlPart)->lists('slug','name');
            if (!$category){
                $post = PostModel::where('slug', $urlPart)->lists('slug','title');
                if(!$post){
                    $results[] = null;
                }else{
                    $results[] = $post;
                }
            }else{
                $results[] = $category;
            }
        }
        $results = array_filter($results);
        $crumbs = [];
        foreach($results as $key => $result){
            foreach ($result as $name => $slug){
                $crumbs[$slug] = $name;
            }
        }
        return($crumbs);
    }
}
