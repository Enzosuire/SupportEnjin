<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdProjetToConversationsprojetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversations', function (Blueprint $table) {
             // Ajoutez la colonne id_projet
             $table->unsignedBigInteger('id_projet')->nullable()->after('id'); // Assurez-vous que 'id' est la colonne après laquelle vous voulez ajouter

             // Ajoutez une contrainte de clé étrangère si vous souhaitez l'associer à la table projet
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
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropForeign(['id_projet']);
            $table->dropColumn('id_projet');
        });
    }
}
