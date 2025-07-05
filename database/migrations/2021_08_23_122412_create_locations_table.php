<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200);
            $table->string('subtitle', 200)->nullable();
            $table->longText('content')->nullable();
            $table->string('category', 200)->nullable();
            $table->longText('image')->nullable();
            $table->longText('image2')->nullable();
            $table->longText('image3')->nullable();
            $table->longText('image4')->nullable();
            $table->string('number', 10)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('city', 200)->nullable();
            $table->string('country', 200)->nullable();
            $table->string('website', 200)->nullable();
            $table->string('phone', 200)->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->boolean('view')->nullable();
            $table->bigInteger('edited_by')->nullable();
            $table->string('url', 200)->nullable();
            $table->string('seo', 200)->nullable();
            $table->string('keywords', 200)->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
