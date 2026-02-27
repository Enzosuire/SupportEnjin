<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projet', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID primaire
            $table->string('nom', 191); // Nom du projet
            $table->date('date_sortie_site'); // Date de sortie du site
            $table->string('maintenance_preventive', 191); // Maintenance préventive
            $table->string('duree_garantie', 191); // Durée de garantie
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrati
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projet');
    }
}
