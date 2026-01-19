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
        Schema::create('service_v2_s', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->json('name');
        $table->json('tagline');
        $table->json('steps')->nullable();
        $table->json("benefits")->nullable();
        $table->json("values")->nullable();
        $table->json("impacts")->nullable();
        $table->boolean('status')->default(true);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_v2_s');
    }
};
