<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMaterial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('registered');
            $table->dropColumn('status');
            $table->enum('register', ['iya', 'tidak'])->default('tidak')->after('quantity');
            $table->enum('stats', ['Dipakai', 'Maintenance', 'Tidak Dipakai', 'Diserahkan'])->after('specification');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->enum('status',['Dipakai','Maintenance','Tidak Dipakai'])->after('specification');
            $table->enum('registered', ['yes', 'no'])->default('no')->after('quantity');
            //
        });
    }
}
