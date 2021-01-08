<?php namespace Wapp\Basecode\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateGalleriesTable extends Migration
{
    public function up()
    {
        Schema::create('gas_pollozen_simplegallery_galleries', function ($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->string('slug')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gas_pollozen_simplegallery_galleries');
    }
}
