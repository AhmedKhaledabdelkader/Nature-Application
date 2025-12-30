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
        Schema::create('award_sponsor', function (Blueprint $table) {
        
             $table->uuid('award_id');
            $table->uuid('sponsor_id');
            $table->primary(['award_id', 'sponsor_id']);

            $table->foreign('award_id')
                ->references('id')->on('awards')
                ->cascadeOnDelete();

            $table->foreign('sponsor_id')
                ->references('id')->on('sponsors')
                ->cascadeOnDelete();
            $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('award_sponsor');
    }
};
