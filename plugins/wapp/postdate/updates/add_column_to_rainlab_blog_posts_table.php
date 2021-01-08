<?php namespace RainLab\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddColumnToPost extends Migration
{

    public function up()
    {
        Schema::table('rainlab_blog_posts', function ($table) {
            $table->boolean('is_region_main')->default(false);
        });
    }

    public function down()
    {
        if (Schema::hasTable('rainlab_blog_posts')) {
            Schema::table('rainlab_blog_posts', function ($table) {
                if (Schema::hasColumn('is_region_main')) {
                    $table->dropColumn('is_region_main');
                }
            });
        }
    }
}
