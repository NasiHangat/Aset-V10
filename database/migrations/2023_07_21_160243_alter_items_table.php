<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('bast');
            $table->dropColumn('quantity');
            $table->dropColumn('harga_satuan');
            $table->dropColumn('harga_total');
            $table->dropColumn('category');
            $table->enum('category', ['Rumah Tangga', 'Laboratorium','ATK'])->after('name');
            $table->string('satuan')->after('category');
            $table->bigInteger('saldo')->after('satuan');
            $table->bigInteger('opsik')->after('saldo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->bigInteger('bast');
            $table->enum('category', ['Aset', 'Persediaan']);
            $table->bigInteger('quantity');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('harga_total', 12, 2);
        });
    }
}
