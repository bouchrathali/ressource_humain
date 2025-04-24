<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('managers', function (Blueprint $table) {
            $table->string('matricul_manager', 255)->primary();
            $table->string('nom', 255);
            $table->string('prenom', 255);
            $table->string('email', 255)->unique();
            $table->string('telephone', 255);
            $table->enum('apartment', [
                'Études',
                'Affaires Juridiques et Foncières',
                'Gestion Urbaine',
                'Planification',
                'Développement Durable'
            ]);
            $table->string('password', 255); // Adequate length for hashed passwords
            $table->rememberToken(); // For "remember me" functionality
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('managers');
    }
};