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
            $table->bigIncrements('id');
            $table->string('name',60)->nullable(false);
            $table->string('last_name',60);
            $table->string('reason_social',60)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar',100)->nullable();
            $table->string('phone',25)->nullable();
            $table->enum('isactive',['active','inactive'])->nullable(false)->default('active');
            $table->enum('role',['administrator','sales','sales_point'])->nullble();
            $table->float('total_credit')->nullable()->default(0.0);
            $table->integer('created_by_id')->nullable();
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
