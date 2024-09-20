<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerProjetTable extends Migration
{
    public function up()
    {
        Schema::create('customer_projet', function (Blueprint $table) {
            // Colonnes pour les relations
            $table->unsignedBigInteger('id_customers');  // 'unsignedBigInteger' pour correspondre à la clé primaire de 'customers'
            $table->unsignedBigInteger('id_projet');     // 'unsignedBigInteger' pour correspondre à la clé primaire de 'projet'
            
            // Définition des clés étrangères
            $table->foreign('id_customers')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('id_projet')->references('id')->on('projet')->onDelete('cascade');
            
            // Définition de la clé primaire composite
            $table->primary(['id_customers', 'id_projet']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_projet');
    }
}
