<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question',200);
            $table->string('subtitle',200)->nullable();
            $table->string('content',200)->nullable();
            $table->string('answer1',200);
            $table->string('answer2',200);
            $table->string('answer3',200);
            $table->string('answer4',200);
            $table->string('answer5',200);
            $table->string('category', 200)->nullable();
            $table->longText('image')->nullable();
            $table->boolean('view');
            $table->bigInteger('edited_by');
            $table->string('url', 200)->nullable();
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
        Schema::dropIfExists('questions');
    }
}
