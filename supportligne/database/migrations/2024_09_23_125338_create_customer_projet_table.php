<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerProjetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_projet', function (Blueprint $table) {
            $table->unsignedInteger('id_customers');
            $table->unsignedBigInteger('id_projet');
            
            // Clés étrangères
            $table->foreign('id_customers')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('id_projet')->references('id')->on('projet')->onDelete('cascade');
            
            // Clé primaire composite
            $table->primary(['id_customers', 'id_projet']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_projet');
    }
}
