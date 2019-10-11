<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_from')->unsigned();
            $table->bigInteger('user_to')->unsigned();
            $table->float('credits')->nullable(false);
            $table->boolean('is_variation')->nullable(false)->default(false);
            $table->enum('variation_type',['increment','decrement'])->nullable();
            $table->float('variation')->nullable();
            $table->timestamps();

            $table->foreign('user_from')->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign('user_to')->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
