<?php

namespace Wapp\Userconnect\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateSubscriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('wapp_userconnect_subscriptions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('subscriber_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('verification_key')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->datetime('verified_at')->nullable();
            $table->datetime('valid_till')->nullable();
            $table->timestamps();
        });

        Schema::table('wapp_userconnect_subscriptions', function (Blueprint $table) {
            $table->foreign('subscriber_id')->references('id')->on('wapp_userconnect_subscribers');
            $table->foreign('category_id')->references('id')->on('wapp_userconnect_categories');
        });
    }

    public function down()
    {
        Schema::table('wapp_userconnect_subscriptions', function (Blueprint $table) {
            $table->dropForeign('wapp_userconnect_subscriptions_subscriber_id_foreign');
            $table->dropForeign('wapp_userconnect_subscriptions_category_id_foreign');
        });
        Schema::dropIfExists('wapp_userconnect_subscriptions');
    }
}
