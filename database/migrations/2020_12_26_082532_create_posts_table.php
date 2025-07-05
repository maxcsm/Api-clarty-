<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

public function up()
{
    Schema::create('posts', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title', 200);
        $table->string('subtitle', 200)->nullable();
        $table->longText('content')->nullable();
        $table->string('category', 200);
        $table->longText('image')->nullable();
        $table->boolean('view')->nullable();
        $table->bigInteger('edited_by');
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
    Schema::dropIfExists('posts');
}
}
