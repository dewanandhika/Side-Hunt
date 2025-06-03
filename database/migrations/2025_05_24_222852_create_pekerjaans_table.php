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
        Schema::create('pekerjaans', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('nama');
            $table->integer('min_gaji');
            $table->integer('max_gaji');
            $table->integer('max_pekerja')->default('0');
            $table->integer('is_active')->default(1);
            $table->bigInteger('pembuat')->unsigned();
            $table->string('deskripsi');
            $table->string('kriteria');
            $table->string('alamat');
            $table->string('petunjuk_alamat');
            $table->string('koordinat');
            $table->string('latitude');
            $table->string('longitude');
            $table->dateTime('start_job');
            $table->dateTime('end_job');
            $table->dateTime('deadline_job')->nullable();
            $table->string('foto_job')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pekerjaans');
    }
};
