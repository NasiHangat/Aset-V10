<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsetKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aset_keluars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nomor');
			$table->string('aset');
			$table->string('pihakSatu')->nullable();
			$table->string('pihakSatuNip')->nullable();
			$table->string('pihakDua')->nullable();
			$table->string('pihakDuaNIP')->nullable();
			$table->string('itemBarang')->nullable();
			$table->string('kepada');
			$table->string('technicalData');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aset_keluars');
    }
}
