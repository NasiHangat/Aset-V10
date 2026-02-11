<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnNoFakturAsetouts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aset_outs', function (Blueprint $table) {
            $table->dropColumn('no_faktur');
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
            $table->string('no_faktur');
        });
    }
}
