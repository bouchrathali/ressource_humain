<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_manager', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('matricul_manager', 255); // Must match managers.matricul_manager
            $table->string('title', 255);
            $table->text('description');
            $table->date('due_date');
            $table->enum('status', ['pending', 'in_progress', 'completed']);
            
            // Add foreign key constraint
            $table->foreign('matricul_manager')
                  ->references('matricul_manager') // References matricul_manager in managers table
                  ->on('managers')
                  ->onDelete('cascade') // or 'restrict' if you prefer
                  ->onUpdate('cascade');
            
            $table->index('matricul_manager');
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_manager', function (Blueprint $table) {
            $table->dropForeign(['matricul_manager']);
        });
        
        Schema::dropIfExists('task_manager');
    }
};