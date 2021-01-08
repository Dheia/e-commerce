<?php namespace Wapp\Postdate\Models\Postsforresult;
use \Rainlab\Blog\Models\Post;
use Carbon\Carbon;

class ResultsPost{
    public function getResultsPosts(){
        $curdate = date("Y-m-d");
        $year = date("Y");
        $posts = Post::where('date_end', '<', $curdate)
            ->where('year', '=', $year)
            ->take(5)
            ->get();
        return $posts;
    }
}
