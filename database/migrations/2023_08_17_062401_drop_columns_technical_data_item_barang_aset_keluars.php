<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnsTechnicalDataItemBarangAsetKeluars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aset_keluars', function (Blueprint $table) {
            $table->dropColumn('technicalData');
            $table->dropColumn('itemBarang');
            $table->string('pihakSatuJabatan');
            $table->string('pihakDuaJabatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('aset_keluars', function (Blueprint $table) {
			$table->string('itemBarang')->nullable();
			$table->string('technicalData');
            $table->dropColumn('pihakSatuJabatan');
            $table->dropColumn('pihakDuaJabatan');
        });
    }
}
