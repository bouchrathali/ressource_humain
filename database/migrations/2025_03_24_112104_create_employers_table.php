<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->string('matricul_employer', 255)->primary();
            $table->string('nom', 255);
            $table->string('prenom', 255);
            $table->string('email', 255)->unique();
            $table->string('telephone', 255);
            $table->string('passwordE', 255);
            $table->string('role', 255);
            $table->date('date_embauche');
            $table->string('post', 255);
            $table->enum('apartment', [
                'Études',
                'Affaires Juridiques et Foncières',
                'Gestion Urbaine',
                'Administratif et Financier'
            ]);
            
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('employers');
    }
};