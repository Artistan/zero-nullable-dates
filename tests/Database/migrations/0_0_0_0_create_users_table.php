<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zero_nullable_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->dateTime('created_date_time');
            $table->dateTimeTz('created_date_time_zoned');
            $table->date('created_date');
            $table->dateTime('created_date_time_null')->nullable();
            $table->dateTimeTz('created_date_time_zoned_null')->nullable();
            $table->date('created_date_null')->nullable();
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
        Schema::dropIfExists('zero_nullable_users');
    }
}
