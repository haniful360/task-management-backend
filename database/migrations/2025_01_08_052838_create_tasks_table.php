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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name'); // Task name
            $table->text('description')->nullable(); // Optional task description
            $table->enum('status', ['pending', 'approved'])->default('pending'); // Task status
            $table->date('due_date')->nullable(); // Optional due date
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key for user
            $table->timestamps(); // Created at & Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
