<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAjuanTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ajuans', function (Blueprint $table) {
			$table->dropColumn('code');
			$table->dropColumn('satuan');
			$table->dropColumn('saldo');
			$table->dropColumn('opsik');
			$table->unsignedBigInteger('faktur_id');
			$table->foreign('faktur_id')->references('id')->on('aset_outs')->onDelete('cascade')->onUpdate('cascade');
			$table->unsignedBigInteger('qty');
			$table->unsignedBigInteger('total_qty');
			$table->enum('status', ['Diproses','Disetujui','Ditolak'])->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ajuans', function (Blueprint $table) {
			$table->dropForeign(['faktur_id']);
			$table->dropColumn('faktur_id');
			$table->dropColumn('qty');
			$table->dropColumn('total_qty');
			$table->dropColumn('status');
			$table->unsignedBigInteger('code')->nullable();
			$table->string('satuan')->nullable();
			$table->unsignedBigInteger('saldo')->nullable();
			$table->unsignedBigInteger('opsik')->nullable();
			//
		});
	}
}
