<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_interventions');
            $table->unsignedInteger('id_customers');
            $table->unsignedInteger('id_projet');
            // $table->unsignedInteger('id_pole');
            $table->float('montant');
            $table->date('date_facturation');
            $table->string('statut');

            $table->timestamps();
        
            // Définir les clés étrangères
            $table->foreign('id_interventions')->references('id')->on('interventions')->onDelete('cascade');
            $table->foreign('id_customers')->references('id')->on('customers')->onDelete('cascade');
            // $table->foreign('id_projet')->references('id')->on('projet')->onDelete('cascade');
            // $table->foreign('id_pole')->references('id')->on('pole')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturations');
    }
}
