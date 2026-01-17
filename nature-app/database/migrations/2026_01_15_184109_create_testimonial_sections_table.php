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
        Schema::create('testimonial_sections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('client_name_en')->nullable();
            $table->string('client_name_ar')->nullable();
            $table->string('job_title_en')->nullable();
            $table->string('job_title_ar')->nullable();
            $table->text('testimonial_en')->nullable();
            $table->text('testimonial_ar')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonial_sections');
    }
};
