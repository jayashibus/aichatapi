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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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


$table->id();
$table->bigInteger('customer_id');
$table->decimal('total_spent', $precision = 10, $scale = 2);
$table->decimal('total_saving', $precision = 10, $scale = 2);
$table->dateTime('transaction_at', $precision = 0);



$table->id();
$table->string('first_name');
$table->string('last_name');
$table->string('gender');
$table->date('date_of_birth');
$table->string('contact_number');
$table->string('email');
$table->timestamps();     


