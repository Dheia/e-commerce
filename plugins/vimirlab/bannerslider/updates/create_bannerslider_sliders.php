<?php namespace VimirLab\BannerSlider\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateBannersliderSlider extends Migration
{
    public function up()
    {
		Schema::create('vimirlab_bannerslider_sliders', function ($table){
			$table->engine = 'InnoDB';
            $table->increments('id');
			$table->string('title');
            $table->timestamps();
		});
	}

    public function down()
    {
        Schema::dropIfExists('vimirlab_bannerslider_sliders');
    }
}