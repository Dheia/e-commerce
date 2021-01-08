<?php namespace Wapp\Basecode\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePostSorevnovania extends Migration
{
    public function up()
    {
        Schema::table('rainlab_blog_posts', function ($table) {
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->string('place')->nullable();
            $table->string('participants')->nullable();
            $table->string('type')->default('no_type');
            $table->boolean('is_main_banner')->default(false);
            $table->boolean('banner_white')->default(false);
        });
    }

    public function down()
    {
        Schema::table('rainlab_blog_posts', function ($table) {
            if (Schema::hasColumn('date_start','date_end','place','participants','type','is_main_banner','banner_white')) {
                $table->dropColumn(['date_start', 'date_end', 'place', 'participants', 'type', 'is_main_banner', 'banner_white']);
            }
        });
    }
}
