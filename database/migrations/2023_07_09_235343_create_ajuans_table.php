<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAjuansTable extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('ajuans', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('code')->nullable();
			$table->string('name')->nullable();
			$table->string('satuan')->nullable();
			$table->unsignedBigInteger('saldo')->nullable();
			$table->unsignedBigInteger('opsik')->nullable();
			$table->enum('status', ['0','1'])->nullable();
			$table->string('pengaju')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('ajuans');
	}
};
