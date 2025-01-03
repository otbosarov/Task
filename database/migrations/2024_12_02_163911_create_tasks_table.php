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
            $table->id();
            $table->string('projectname');
            $table->string('dascription');
            $table->date('start_date');
            $table->date('expiration_date');
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('active')->default(true);
            $table->date('project_completed_time')->nullable();
            $table->foreignId('partner_id')->nullable()->constrained('users')->onDelete("RESTRICT");
            $table->string('status')->default('ADDED');
            $table->timestamps();
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
