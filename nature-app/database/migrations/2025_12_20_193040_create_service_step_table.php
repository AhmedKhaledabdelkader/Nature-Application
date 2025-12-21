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
        Schema::create('provided__service_step', function (Blueprint $table) {
   
    $table->uuid('provided__service_id');
    $table->uuid('step_id');
    $table->integer('order_index'); // 👈 ORDER PER SERVICE
    $table->primary(['provided__service_id', 'step_id']);
    $table->foreign('provided__service_id')->references('id')->on('provided__services')->cascadeOnDelete();
    $table->foreign('step_id')->references('id')->on('steps')->cascadeOnDelete();
    $table->unique(['provided__service_id', 'order_index']); // prevents duplicate order
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_step');
    }


};
