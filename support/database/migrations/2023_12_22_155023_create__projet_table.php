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
            $table->increments('id');
            $table->unsignedInteger('id_customers');
            $table->string('nom');
            $table->date('date_sortie_site')->nullable();
            
        
            $table->foreign('id_customers')->references('id')->on('customers')->onDelete('cascade');
        
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_projet');
    }
}
