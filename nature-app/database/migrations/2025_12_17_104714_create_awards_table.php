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
        Schema::create('awards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('title');
            $table->json('description');
            $table->string('image');
            $table->string('year');
          //  $table->json('url');
            $table->json('organization_name');
            $table->string('organization_logo');
           // $table->string('content_file') ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('awards');
    }
};
