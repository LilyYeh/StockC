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
        Schema::create('barn', function (Blueprint $table) {
            $table->id();
            $table->integer('iid')->comment('商品ID');
            $table->integer('uid')->comment('掛單者ID');
            $table->integer('price')->comment('價格');
            $table->integer('type')->comment('(1)多倉(2)空倉');
            $table->integer('clinch')->comment('(0)未成交(1)成交')->default(0);
            $table->integer('clinch_id')->comment('成交單號')->nullable();
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
        Schema::dropIfExists('barn');
    }
};
