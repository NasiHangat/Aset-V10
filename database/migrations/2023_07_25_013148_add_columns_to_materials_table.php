<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->enum('registered', ['iya', 'tidak'])->default('tidak')->after('quantity');
            $table->enum('status', ['Dipakai', 'Maintenance', 'Tidak Dipakai', 'Diserahkan'])->after('specification');
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
            $table->dropColumn('register');
            $table->dropColumn('stats');
        });
    }
}
