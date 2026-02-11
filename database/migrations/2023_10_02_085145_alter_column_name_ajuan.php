<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnNameAjuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ajuans', function (Blueprint $table) {
			$table->unsignedBigInteger('name');
			$table->foreign('name')->references('id')->on('items')->onDelete('cascade')->onUpdate('cascade');
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
			$table->dropForeign(['name']);
			$table->dropColumn('name');
        });
    }
}
