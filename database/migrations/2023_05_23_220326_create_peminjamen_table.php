<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamenTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('employee_id');
			$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');
			$table->string('peminjam');
			$table->string('code')->unique();
			$table->unsignedBigInteger('material_id');
			$table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade')->onUpdate('cascade');
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali');
			$table->time('jam_pinjam')->nullable();
			$table->time('jam_kembali')->nullable();
			$table->enum('status', ['Dipinjam', 'Dikembalikan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
