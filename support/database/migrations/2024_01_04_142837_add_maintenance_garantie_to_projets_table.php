<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaintenanceGarantieToProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projet', function (Blueprint $table) {
            $table->string('maintenance_preventive')->nullable();
            $table->string('duree_garantie')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projet', function (Blueprint $table) {
            $table->dropColumn('maintenance_preventive');
            $table->dropColumn('duree_garantie');
        });
    }
}
