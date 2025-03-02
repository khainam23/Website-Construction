<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->string('location');
            $table->integer('quantity')->default(0);
            $table->enum('status', ['in_stock', 'out_of_stock', 'low_stock'])->default('in_stock');
            $table->timestamps();

            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventories');
    }
};
