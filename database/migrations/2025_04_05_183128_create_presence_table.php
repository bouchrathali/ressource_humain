<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('presence', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to employers table
            $table->string('matricule_employer', 255);
            $table->foreign('matricule_employer')
                  ->references('matricul_employer') // Must match the column name in employers table
                  ->on('employers')
                  ->onDelete('cascade'); // Deletes presence records when employer is deleted
            
            $table->date('date');
            $table->time('arrive_time')->nullable();
            $table->time('leave_time')->nullable();
            $table->enum('status', ['post_empty', 'at_work', 'on_vacation'])
                  ->default('post_empty');
            
            // Composite unique index
            $table->unique(['matricule_employer', 'date']);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('presence');
    }
};