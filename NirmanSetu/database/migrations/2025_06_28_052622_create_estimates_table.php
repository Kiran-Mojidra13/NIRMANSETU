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
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('client_id');
            $table->string('title');
            $table->decimal('total_amount', 12, 2);
            $table->string('pdf_path')->nullable();
            $table->enum('status', ['draft', 'approved'])->default('draft');
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('client_id');
            $table->string('title');
            $table->decimal('total_amount', 12, 2);
            $table->string('pdf_path')->nullable();
            $table->enum('status', ['due', 'paid', 'overdue'])->default('due');
            $table->date('due_date');
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->decimal('amount', 12, 2);
            $table->date('paid_on');
            $table->string('method')->nullable(); // e.g., bank, cash
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('estimates');
    }
};