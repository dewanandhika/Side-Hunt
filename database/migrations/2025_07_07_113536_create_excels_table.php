<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('excels', function (Blueprint $table) {
            $table->id();
            $table->string('code_barang')->nullable();
            $table->string('nama')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('harga_beli')->nullable();
            $table->integer('total_jual')->nullable();
            $table->integer('total_beli')->nullable();
            $table->integer('harga_jual')->nullable();
            $table->string('pembeli')->nullable();
            $table->dateTime('tanggal')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excels');
    }
};
