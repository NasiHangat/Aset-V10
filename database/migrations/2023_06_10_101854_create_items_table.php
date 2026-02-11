<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255)->unique();
            $table->bigInteger('bast');
            $table->string('name', 255);
            $table->enum('category', ['Aset', 'Persediaan']);
            $table->bigInteger('quantity');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('harga_total', 12, 2);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
