<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_available')->default(true);
            $table->integer('minimum_children');
            $table->integer('minimum_adults');
            $table->double('base_price');
            $table->double('adult_price');
            $table->double('child_price');
            $table->double('taxes');
            $table->double('discount');
            $table->text("characteristics");
            $table->foreignId('hotel_id')->references('id')->on('hotels');
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
        Schema::dropIfExists('rooms');
    }
};