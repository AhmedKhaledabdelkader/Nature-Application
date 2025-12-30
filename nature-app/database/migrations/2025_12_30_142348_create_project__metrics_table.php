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
        Schema::create('project__metrics', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('metric_name') ;
            $table->string('metric_value') ;
            $table->enum('trend', ['up', 'down','stable'])->nullable() ;
             $table->uuid('project_id');
            $table->foreign('project_id')
           ->references('id')
           ->on('projects')
           ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project__metrics');
    }
};
