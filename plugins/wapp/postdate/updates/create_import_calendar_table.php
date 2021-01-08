<?php namespace RainLab\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCalendarTable extends Migration
{

    public function up()
    {
        Schema::create('gas_calendar', function ($table) {
            $table->increments('id');
            $table->string('article_url')->nullable();
            $table->string('article_title')->nullable();
            $table->string('article_slug')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->string('year')->nullable();
            $table->string('place')->nullable();
            $table->string('participants')->nullable();
            $table->string('article_type')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gas_calendar');
    }
}
