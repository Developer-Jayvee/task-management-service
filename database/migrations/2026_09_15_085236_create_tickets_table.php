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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable();
            $table->foreignId('project_id')->nullable();
            $table->string("title");
            $table->string("description")->nullable();
            $table->enum("status",['to-do','in-progress','completed']);
            $table->enum('priority',['low','medium','high']);
            $table->foreignId('assignee_id')->nullable();
            $table->date("due_date");
            $table->foreignId('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
