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
        Schema::create('invitation_links', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->foreignId("user_id")->nullable();
            $table->foreignId("tenant_id")->nullable();
            $table->string("link");
            $table->boolean('is_accepted')->default(false);
            $table->dateTime("expiration_date");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_links');
    }
};
