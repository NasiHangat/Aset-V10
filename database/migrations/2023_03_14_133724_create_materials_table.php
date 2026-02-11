<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('nup');
            $table->string('name',100);
            $table->string('name_fix', 100)->nullable();
            $table->string('no_seri')->nullable();
            $table->unsignedBigInteger('years');
            $table->enum('condition', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
            $table->string('documentation', 100)->nullable()->default(null);
            $table->text('specification')->nullable();
            $table->enum('status',['Dipakai','Maintenance','Tidak Dipakai']);
            $table->enum('type', ['Tetap', 'Bergerak']);
            $table->string('dikalibrasi', 100)->nullable();
            $table->bigInteger('last_kalibrasi')->nullable();
            $table->bigInteger('schadule_kalibrasi')->nullable();
            $table->string('kalibrasi_by')->nullable();
            $table->bigInteger('category')->nullable();
            $table->string('store_location', 200)->nullable();
            $table->string('supervisor', 200)->nullable();
            $table->string('description', 200)->nullable();
            $table->date('life_time')->nullable();
            $table->bigInteger('quantity')->nullable()->default(0);
            $table->enum('registered', ['yes', 'no'])->default('no');
            $table->string('satuan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
