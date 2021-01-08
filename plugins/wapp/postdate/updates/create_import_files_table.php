<?php namespace RainLab\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateImportFilesTable extends Migration
{

    public function up()
    {
        Schema::create('gas_file_news', function ($table) {
            $table->increments('id');
            $table->string('orig_src')->nullable();
            $table->string('full_url')->nullable();
            $table->string('new_name')->nullable();
            $table->string('article_slug')->nullable();
            $table->string('file_type')->nullable();
            $table->boolean('is_preview')->nullable();
            $table->boolean('is_download')->nullable();
            $table->string('description')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gas_file_news');
    }
}

