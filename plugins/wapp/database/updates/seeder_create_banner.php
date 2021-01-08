<?php namespace Wapp\Database\Updates;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Input;
use October\Rain\Database\Updates\Seeder;
use System\Models\File as File;
use VimirLab\BannerSlider\Models\Slider;

class SeederCreateBanner extends Seeder
{

    public function run()
    {
        $banner = Slider::create(['title' => 'home']);

        for ($i = 0; $i < 3; $i++) {
            $sFileName = 'banner.jpg';
            $sImagePath = 'themes/dist/assets/img';
            $obImage = new File();
            $obImage->fromFile($sImagePath . '/' . $sFileName);

            $slideData = [
                'title' => 'title example',
                'display' => true,
                'image' => $obImage,
                'subtitle' => 'subtitle',
                'extra_text' => '',
            ];

            $banner->slides()->create($slideData);
        }
    }
}
