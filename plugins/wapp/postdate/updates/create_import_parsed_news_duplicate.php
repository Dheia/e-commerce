<?php namespace RainLab\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateNewsDuplicateTable extends Migration
{

    public function up()
    {
        Schema::create('gas_parsed_news_duplicate', function ($table) {
            $table->increments('id');
            $table->string('url')->nullable();
            $table->string('title')->nullable();
            $table->string('additional_category')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gas_parsed_news_duplicate');
    }
}
