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
        Schema::create('users', function (Blueprint $table) {
    
    
    
    
            $table->bigIncrements('id');        
            $table->string('salutation')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->longText('user_avatar')->nullable();
            $table->string('status')->nullable();
            $table->string('website')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('phone_mobile')->nullable();
            $table->string('customer_type')->nullable();
            $table->string('code')->nullable();


            $table->string('address')->nullable();
            $table->string('cp')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('billing_fax')->nullable();


            $table->string('shipping_address')->nullable();
            $table->string('shipping_cp')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->string('shipping_fax')->nullable();



            $table->integer('payment_terms')->nullable();
            $table->string('payment_terms_label')->nullable();
            $table->boolean('payment_reminder')->default(1);
         
    
            $table->string('tva_number')->nullable();
            $table->string('siret_number')->nullable();
       
          
            $table->string('company')->nullable();
            $table->string('role')->nullable();
            $table->string('pushid')->nullable();
       

            $table->longText('notes')->nullable();



            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
