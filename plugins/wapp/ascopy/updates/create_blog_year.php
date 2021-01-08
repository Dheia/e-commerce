<?php namespace Wapp\Basecode\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBlogYear extends Migration
{
    public function up()
    {
        Schema::table('rainlab_blog_posts', function ($table) {
            $table->string('year')->nullable();
        });
    }

    public function down()
    {
        if (Schema::hasTable('rainlab_blog_posts')) {
            Schema::table('rainlab_blog_posts', function ($table) {
                if (Schema::hasColumn('year')) {
                    $table->dropColumn('year');
                }
            });
        }
    }
}
