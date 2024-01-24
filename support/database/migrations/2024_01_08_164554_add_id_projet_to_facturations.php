<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdProjetToFacturations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facturations', function (Blueprint $table) {
            $table->unsignedInteger('id_projet')->nullable();
            $table->foreign('id_projet')->references('id')->on('projet')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facturations', function (Blueprint $table) {
            $table->unsignedInteger('id_projet')->nullable();
            $table->foreign('id_projet')->references('id')->on('projet')->onDelete('cascade');
        });
    }
}
