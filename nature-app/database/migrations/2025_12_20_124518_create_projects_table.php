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
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('name');
            $table->string('image_before');
            $table->string('image_after');
            $table->json('overview');
            $table->json('brief') ;
            $table->json('gallery');
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->json("results")->nullable();
            $table->json('metrics')->nullable();
            $table->boolean('status')->default(true);
            $table->uuid('country_id');
            $table->uuid('city_id');
            $table->foreign('city_id')
           ->references('id')
           ->on('cities')
           ->onDelete('cascade');
           $table->foreign('country_id')
           ->references('id')
           ->on('countries')
           ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
