<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('utilisateur', function (Blueprint $table) {
            $table->string('code_pin')->nullable(); // Ajoute une colonne code_pin
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('utilisateur', function (Blueprint $table) {
            $table->dropColumn('code_pin');
        });
    }
    
};
