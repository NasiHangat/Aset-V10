<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAsetOutsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('aset_outs', function (Blueprint $table) {
			$table->dropColumn('satuan');
			$table->dropColumn('name');
			$table->dropColumn('qty');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('aset_outs', function (Blueprint $table) {
			$table->string('name');
			$table->unsignedBigInteger('qty');
			$table->string('satuan');
		});
	}
}
