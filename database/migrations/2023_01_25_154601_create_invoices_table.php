<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('CustomerID')->nullable();
            $table->string('ItemName', 200);
            $table->longText('ItemDesc')->nullable();
            $table->decimal('ItemPrice', 5, 2)->nullable();
            $table->decimal('ItemTotal', 5, 2)->nullable();

            $table->date('DueDate')->nullable();
            $table->date('InvoiceDate')->nullable();


            $table->decimal('ItemTax1', 5, 2)->nullable();
            $table->decimal('ItemTax1Amount', 5, 2)->nullable();
            $table->decimal('Total', 5, 2)->nullable();
            $table->bigInteger('Quantity')->nullable();

       
            $table->longText('content')->nullable();
            $table->bigInteger('InvoiceID');
            $table->bigInteger('InvoiceNumber');
            $table->bigInteger('InvoiceStatus');
      
      
     

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
        Schema::dropIfExists('invoices');
    }
};
