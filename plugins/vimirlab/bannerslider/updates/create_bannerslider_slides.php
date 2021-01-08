<?php namespace VimirLab\BannerSlider\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateBannersliderSlides extends Migration
{
    public function up()
    {
		Schema::create('vimirlab_bannerslider_slides', function ($table){
			$table->engine = 'InnoDB';
            $table->increments('id');
			$table->string('title', 30);
			$table->integer('slider_id');
			$table->string('subtitle', 50);
			$table->string('extra_text', 300);
            $table->integer('title_size')->default(40);
            $table->integer('subtitle_size')->default(25);
            $table->string('title_color', 7)->default('#FFFFFF');
            $table->string('subtitle_color', 7)->default('#FFFFFF');
            $table->string('extra_text_color', 7)->default('#FFFFFF');
            $table->string('text_align', 6)->default('center');
            $table->boolean('button_1_active')->default(false);
            $table->string('button_1_text', 20)->nullable();
            $table->string('button_1_link', 300)->nullable();
            $table->boolean('button_2_active')->default(false);
            $table->string('button_2_text', 20)->nullable();
            $table->string('button_2_link', 300)->nullable();
            $table->boolean('display')->default(true);
            $table->integer('sort_order')->nullable();
            $table->timestamps();
		});
	}

    public function down()
    {
        Schema::dropIfExists('vimirlab_bannerslider_slides');
    }
}