<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAsetOuts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aset_outs', function (Blueprint $table) {
            $table->string('mak')->after('no_faktur')->nullable();
            $table->string('no_nd')->after('mak')->nullable();
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
            $table->dropColumn('mak');
            $table->dropColumn('no_nd');
        });
    }
}
