<?php namespace Wapp\Postdate\Components;

use Cms\Classes\ComponentBase;
use RainLab\Blog\Models\Post;

class ResultsPost extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'ResultsPost Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function getResultsPosts(){
        $curdate = date("Y-m-d");
        $year = date("Y");
        $posts = Post::where('date_end', '<', $curdate)
            ->where('year', '=', $year)
            ->orderByDesc('date_end')
            ->take(5)
            ->get();
        return $posts;
    }
}
