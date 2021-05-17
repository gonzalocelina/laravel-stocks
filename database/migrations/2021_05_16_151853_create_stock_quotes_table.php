<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_quotes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('symbol');
            $table->decimal('high', 15, 4);
            $table->decimal('low', 15, 4);
            $table->decimal('price', 15, 4);
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
        Schema::dropIfExists('stock_quotes');
    }
}
