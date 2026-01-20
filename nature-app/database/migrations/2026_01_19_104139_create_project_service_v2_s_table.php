<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_service_v2_s', function (Blueprint $table) {
            $table->uuid('project_id');
            $table->uuid('service_v2_id');

            // Composite primary key
            $table->primary(['project_id', 'service_v2_id']);

            // Foreign keys
            $table->foreign('service_v2_id')
                  ->references('id')
                  ->on('service_v2_s')
                  ->onDelete('cascade');

            $table->foreign('project_id')
                  ->references('id')
                  ->on('projects')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_service_v2_s');
    }
};
