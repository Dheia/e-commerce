<?php namespace RainLab\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddPriorityToPost extends Migration
{

    public function up()
    {
        Schema::table('rainlab_blog_posts', function ($table) {
            $table->integer('priority')->default(1);
        });
    }

    public function down()
    {
        if (Schema::hasTable('rainlab_blog_posts')) {
            Schema::table('rainlab_blog_posts', function ($table) {
                if (Schema::hasColumn('priority')) {
                    $table->dropColumn('priority');
                }
            });
        }
    }
}
