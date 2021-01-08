<?php namespace RainLab\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddColumnPostToPost extends Migration
{

    public function up()
    {
        Schema::table('rainlab_blog_posts', function ($table) {
            $table->mediumText('peoples')->nullable();
        });
    }

    public function down()
    {
        if (Schema::hasTable('rainlab_blog_posts')) {
            Schema::table('rainlab_blog_posts', function ($table) {
                if (Schema::hasColumn('peoples')) {
                    $table->dropColumn('peoples');
                }
            });
        }
    }
}
