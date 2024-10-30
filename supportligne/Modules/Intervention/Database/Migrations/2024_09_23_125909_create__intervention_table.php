<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterventionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->increments('id'); // Clé primaire

            // Colonnes supplémentaires
            $table->string('types_interventions');
            $table->text('description')->nullable();
            $table->dateTime('date_intervention');
            $table->unsignedInteger('id_users'); // Clé étrangère vers la table users
            $table->unsignedBigInteger('id_projet'); // Clé étrangère vers la table projets
            $table->integer('temps_alloue')->nullable();
            $table->string('numero_ticket_jira')->nullable();

            // Colonnes automatiques pour la création et la mise à jour
            $table->timestamps();

            // Clés étrangères
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('_intervention');
    }
}
