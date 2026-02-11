<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use function PHPUnit\Framework\MockObject\Builder\after;

class AlterColumnNoFakturAsetouts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aset_outs', function (Blueprint $table) {
            $table->string('no_faktur')->after('id')->nullable();
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
            $table->dropColumn('no_faktur');
        });
    }
}
