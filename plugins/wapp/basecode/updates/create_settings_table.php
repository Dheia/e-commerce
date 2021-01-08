<?php namespace Wapp\Basecode\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('wapp_basecode_settings', function (Blueprint $table) {
            Schema::dropIfExists('wapp_basecode_settings');
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wapp_basecode_settings');
    }
}
