<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag_fr')->nullable();
            $table->string('tag_en')->nullable();
            $table->string('tag_de')->nullable();
            $table->integer('type')->nullable();
            $table->boolean('isChecked')->default(1);
            $table->timestamps();
        });


        Schema::create('tags_location', function (Blueprint $table) {

            $table->increments('pivot_id');
            $table->integer('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->timestamps();
           // $table->primary(['pivot_id', 'tag_id'], 'cafes_users_tags_primary');
          //  $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::drop('tags_location');
        Schema::drop('tags');
     
    }
}
