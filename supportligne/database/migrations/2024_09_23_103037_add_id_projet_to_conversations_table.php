<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdProjetToConversationsTable extends Migration
{
    public function up()
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->unsignedBigInteger('id_projet')->nullable()->after('id'); // Assurez-vous d'ajouter la colonne après une colonne existante, ici `id`
            
            // Ajoutez la clé étrangère
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
            $table->dropForeign(['id_projet']); // Supprimez la clé étrangère
            $table->dropColumn('id_projet'); // Supprimez la colonne
        });
    }
}
