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
        Schema::create('project_provided__service', function (Blueprint $table) {
            $table->uuid('project_id');
            $table->uuid('provided__service_id');
            $table->primary(['project_id', 'provided__service_id']);

            $table->foreign('project_id')
                ->references('id')->on('projects')
                ->cascadeOnDelete();

            $table->foreign('provided__service_id')
                ->references('id')->on('provided__services')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_provided__service');
    }
};
