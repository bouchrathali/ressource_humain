<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('presence_manager', function (Blueprint $table) {
            $table->id();
            $table->string('matricul_manager');
            $table->date('date');
            $table->string('status'); // present, absent, late, on_leave
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->timestamps();
            
            // Add foreign key if needed
            // $table->foreign('matricul_manager')->references('matricul_manager')->on('managers');
        });
    }

    public function down()
    {
        Schema::dropIfExists('presence_manager');
    }
};