<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyProgressPhotosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('daily_progress_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('set null');
            $table->foreignId('task_id')->nullable()->constrained('tasks')->onDelete('set null');
            $table->string('photo_path'); // e.g. 'uploads/daily_progress/filename.jpg'
            $table->text('remarks')->nullable();
            $table->date('date')->nullable(); // optional, to track date of work
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('daily_progress_photos');
    }
}
