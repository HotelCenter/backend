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
            $table->date('date_available');
            $table->date('date_booked');
            $table->unsignedInteger('minimum_children');
            $table->unsignedInteger('minimum_adults');
            $table->decimal('base_price', 8, 2, true);
            $table->decimal('adult_price', 8, 2, true);
            $table->decimal('child_price', 8, 2, true);
            $table->decimal('taxes', 8, 2, true);
            $table->unsignedInteger('discount');
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