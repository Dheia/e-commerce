<?php namespace Wapp\Basecode\Components;

use Cms\Classes\ComponentBase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use RainLab\Blog\Models\Post;
use PolloZen\SimpleGallery\Models\Gallery as SimpleGallery;

class Import extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name' => 'wapp.basecode::lang.component.compare_title',
            'description' => 'wapp.basecode::lang.component.compare_description',
        ];
    }

    public function onAttachAlbumToPost()
    {
        $get_galleries = DB::select('select name, slug from gas_pollozen_simplegallery_galleries');
        foreach ($get_galleries as $gallery) {
            $post = Post::where('slug', $gallery->slug)->first();
            $album = SimpleGallery::where('name', $gallery->name)->first();

            if ($post and $album) {
                $attached_gallery = DB::table('pollozen_simplegallery_galleries_posts')
                    ->where('post_id', $post->id)
                    ->where('gallery_id', $album->id)->exists();
                if (!$attached_gallery) {
                    DB::table('pollozen_simplegallery_galleries_posts')->insert([
                        'post_id' => $post->id,
                        'gallery_id' => $album->id
                    ]);
                }
            } elseif (empty($post) and empty($album) and $gallery->slug) {
                file_put_contents(
                    'log_attach_album.txt',
                    'Пост - ' . $gallery->slug . ' и альбом - ' . $gallery->name . ' не найдены' . "\n",
                    FILE_APPEND
                );
            } elseif (empty($post) and $gallery->slug) {
                file_put_contents(
                    'log_attach_album.txt',
                    'Пост - ' . $gallery->slug . ' для альбома - ' . $gallery->name . ' не найден' . "\n",
                    FILE_APPEND
                );
            } elseif (empty($album) and $gallery->slug) {
                file_put_contents(
                    'log_attach_album.txt',
                    'Альбом - ' . $gallery->name . ' для поста - ' . $gallery->slug . ' не найден' . "\n",
                    FILE_APPEND
                );
            }
        }
        $response_album = 'Привязка прошла успешно!';
        if (file_exists('log_attach_album.txt')) {
            $response_album = 'Что-то пошло не так. Подробнее в log_attach_album.txt';
        }
        return $response_album;
    }
}
