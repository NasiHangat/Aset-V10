<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsetoutTable extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('aset_outs', function (Blueprint $table) {
			$table->bigIncrements('id');
            $table->string('no_faktur');
			$table->string('name');
			$table->unsignedBigInteger('qty');
			$table->string('satuan');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('aset_outs');
	}
};
