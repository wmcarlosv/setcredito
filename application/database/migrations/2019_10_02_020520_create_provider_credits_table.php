<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_credits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('provider')->nullable(false);
            $table->bigInteger('user_sales_point_id')->unsigned();
            $table->float('credit')->nullable(false);
            $table->timestamps();

            $table->foreign('user_sales_point_id')->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_credits');
    }
}
