<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('phoneNumber');
            $table->string('companyName');
            $table->string('companyRole');
            $table->string('companyWebsite')->nullable();
            $table->string('googleProfile')->nullable();
            $table->string('facebookProfile')->nullable();
            $table->string('image')->nullable();
//            $table->foreignId('role_id')->default(3)->constrained();
             $table->unsignedInteger('role_id')->default(3);
            $table->boolean('admin_approval')->default(0);
            $table->dateTime('time_in')->default(date("Y-m-d H:i:s"))->nullable();
            $table->dateTime('time_out')->default(date("Y-m-d H:i:s"))->nullable();
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
}
