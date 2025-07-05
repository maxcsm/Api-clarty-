<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200);
            $table->longText('content');
            $table->string('category', 200);
            $table->bigInteger('ref');
            $table->decimal('width', 5, 2);
            $table->decimal('height', 5, 2);
            $table->decimal('weight', 5, 2);
            $table->decimal('price', 5, 2);
            $table->longText('image')->nullable();
            $table->boolean('view');
            $table->bigInteger('edited_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
