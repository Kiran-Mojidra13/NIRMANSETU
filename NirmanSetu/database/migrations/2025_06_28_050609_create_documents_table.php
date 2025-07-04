<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('file_path');
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('uploaded_by')->constrained('users'); // uploader
            $table->foreignId('client_id')->nullable()->constrained('users'); // client if any
            $table->foreignId('project_id')->nullable()->constrained('projects'); // related project if any
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};